<?php


namespace App\Tests\Functional;


use App\Entity\Category;

// silent deprecation notices
/**
 * @group legacy
 */
class SubcategoryResourceTest extends CustomApiTestCase
{
//    TODO: other tests and for other Entities

    public function test_givenTwoUsers_whenCreateSubcategoryForCategoryBelongToOtherUser_thenFailure()
    {
        $client = self::createClient();
        $user1 = $this->createUserAndLogin($client, 'test1@example.com', 'qwerty123');
        $user2 = $this->createUser('test2@example.com', 'qwerty123');

        $category1 = (new Category())
            ->setName('example1')
            ->setUserAccount($user1);
        $category2 = (new Category())
            ->setName('example2')
            ->setUserAccount($user2);
        $em = $this->getEntityManager();
        $em->persist($category1);
        $em->persist($category2);
        $em->flush();

        $client->request('POST', self::SUBCATEGORY_API, [
            'json' => [
                'name' => 'example',
                'color' => '#ffffff',
                'category' => self::CATEGORY_API . '/' . 2
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
