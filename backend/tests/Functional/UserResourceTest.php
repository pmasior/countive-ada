<?php


namespace App\Tests\Functional;



// silent deprecation notices
/**
 * @group legacy
 */
class UserResourceTest extends CustomApiTestCase
{
    public function test_givenNothing_whenCreateUser_thenSuccess()
    {
        $client = self::createClient();

        $client->request('POST', self::USER_API, [
            'json' => [
                'email' => 'test@example.com',
                'password' => 'qwerty123',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $this->logIn($client, 'test@example.com', 'qwerty123');
        $this->assertResponseStatusCodeSame(204);
    }

    public function test_givenCreatedUser_whenLoginUser_thenSuccess()
    {
        $client = self::createClient();
        $user = $this->createUser('test@example.com', 'qwerty123');

        $this->logIn($client, 'test@example.com', 'qwerty123');

        $this->assertResponseStatusCodeSame(204);
    }

    public function test_givenLoginUser_whenChangeEmail_thenSuccess()
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $client->request('PUT', self::USER_API . '/' . $user->getId(), [
            'json' => [
                'email' => 'test2@example.com'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'email' => 'test2@example.com'
        ]);
    }

    public function test_givenLoginUser_whenRetrieve_thenNoPasswordInResponse()
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'test@example.com', 'qwerty123');

        $response = $client->request('GET', self::USER_API . '/' . $user->getId());

        $data = $response->toArray();
        $this->assertArrayNotHasKey('password', $data);
        $this->assertArrayNotHasKey('plainPassword', $data);
    }
}
