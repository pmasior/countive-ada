<?php

namespace App\Tests\Functional;

use App\Entity\Category;

// silent deprecation notices
/**
 * @group legacy
 */
class CategoryResourceTest extends CustomApiTestCase
{
    public function test_givenAnonymous_whenReadCategory_thenUnauthorized(): void
    {
        $client = self::createClient();

        $client->request('GET', self::CATEGORY_API, [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function test_givenLoginUser_whenReadCategories_thenSuccess(): void
    {
        $client = self::createClient();
        $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $client->request('GET', self::CATEGORY_API, [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function test_givenAnonymous_whenCreateCategory_thenUnauthorized(): void
    {
        $client = self::createClient();

        $client->request('POST', self::CATEGORY_API, [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function test_givenLoginUser_whenCreateEmptyCategory_thenUnprocessableEntity(): void
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $client->request('POST', self::CATEGORY_API, [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function test_givenLoginUser_whenCreateCategory_thenCreated(): void
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $client->request('POST', self::CATEGORY_API, [
            'json' => [
                'name' => 'example',
                'user' => self::USER_API . '/' . $user->getId()
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function test_givenLoginUser_whenCreateCategoryWithOtherUser_thenUnprocessableEntity(): void
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');
        $otherUser = $this->createUser('other_user@example.com', 'qwerty123');

        $client->request('POST', self::CATEGORY_API, [
            'json' => [
                'name' => 'example',
                'user' => self::USER_API . '/' . $otherUser->getId(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(422, 'Pass incorrect owner');
    }

    public function test_givenLoginUser_whenCreateCategoryWithoutUser_thenCreated(): void
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $client->request('POST', self::CATEGORY_API, [
            'json' => [
                'name' => 'example'
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function test_givenLoginUser_whenReplaceCategory_thenFailure()
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $category = (new Category())
            ->setName('example')
            ->setUserAccount($user);
        $em = $this->getEntityManager();
        $em->persist($category);
        $em->flush();

        $client->request('PUT', self::CATEGORY_API . '/' . $category->getId(), [
            'json' => ['title' => 'updated']
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function test_givenOtherUser_whenReplaceCategory_thenForbidden()
    {
        $client = self::createClient();
        $user1 = $this->createUser('test1@example.com', 'qwerty123');
        $user2 = $this->createUserAndLogin($client, 'test2@example.com', 'qwerty123');

        $category = (new Category())
            ->setName('example')
            ->setUserAccount($user1);
        $em = $this->getEntityManager();
        $em->persist($category);
        $em->flush();

        $client->request('PUT', self::CATEGORY_API . '/' . $category->getId(), [
            'json' => ['title' => 'updated']
        ]);

        $this->assertResponseStatusCodeSame(404);  // 403, before create CategoryOwnerExtension
    }

    public function test_givenOtherUser_whenReplaceUserInCategory_thenFailure()
    {
        $client = self::createClient();
        $user1 = $this->createUser('test1@example.com', 'qwerty123');
        $user2 = $this->createUserAndLogin($client, 'test2@example.com', 'qwerty123');

        $category = (new Category())
            ->setName('example')
            ->setUserAccount($user1);
        $em = $this->getEntityManager();
        $em->persist($category);
        $em->flush();

        $client->request('PUT', self::CATEGORY_API . '/' . $category->getId(), [
            'json' => [
                'title' => 'updated',
                'user' => self::USER_API . '/' . $user2->getId()
            ]
        ]);

        $this->assertResponseStatusCodeSame(404);  // 403, before create CategoryOwnerExtension
    }

    public function test_givenTwoUsers_whenRetrieveCategories_thenReturnOnlyForThisUser()
    {
        $client = self::createClient();
        $user1 = $this->createUserAndLogin($client, 'test1@example.com', 'qwerty123');
        $user2 = $this->createUser('test2@example.com', 'qwerty123');

        $category1 = (new Category())
            ->setName('example')
            ->setUserAccount($user1);
        $category2 = (new Category())
            ->setName('example')
            ->setUserAccount($user2);
        $em = $this->getEntityManager();
        $em->persist($category1);
        $em->persist($category2);
        $em->flush();

        $client->request('GET', self::CATEGORY_API);

        $this->assertJsonContains([
            'hydra:totalItems' => 1
        ]);
    }

    public function test_givenTwoUsers_whenRetrieveOtherUserCategory_thenFailure()
    {
        $client = self::createClient();
        $user1 = $this->createUser('test1@example.com', 'qwerty123');
        $user2 = $this->createUserAndLogin($client, 'test2@example.com', 'qwerty123');

        $category1 = (new Category())
            ->setName('example')
            ->setUserAccount($user1);
        $em = $this->getEntityManager();
        $em->persist($category1);
        $em->flush();

        $client->request('GET', self::CATEGORY_API . '/' . $category1->getId());

        $this->assertResponseStatusCodeSame(404);
    }

    public function test_givenTwoUsers_whenRetrieveUser_thenCategoryOnlyForUser()
    {
        // given
        $client = self::createClient();
        $user1 = $this->createUserAndLogin($client,'test1@example.com', 'qwerty123');
        $user2 = $this->createUser('test2@example.com', 'qwerty123');

        $category1 = (new Category())
            ->setName('example')
            ->setUserAccount($user2);
        $em = $this->getEntityManager();
        $em->persist($category1);
        $em->flush();

        // when
        $response = $client->request('GET', self::USER_API . '/' . $user1->getId());

        // then
        $data = $response->toArray();
        $this->assertEmpty($data['categories']);
    }
}
