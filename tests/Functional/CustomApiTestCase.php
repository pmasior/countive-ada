<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\UserAccount;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// silent deprecation notices
/**
 * @group legacy
 */
class CustomApiTestCase extends ApiTestCase
{
    use ReloadDatabaseTrait;

    const CATEGORY_API = '/api/categories';
    const SUBCATEGORY_API = '/api/subcategories';
    const LOGIN_API = '/login';
    const USER_API = '/api/users';

    protected function createUser(string $email, string $plainPassword): UserAccount
    {
        $user = (new UserAccount())
            ->setEmail($email);
        $userPasswordEncoder = self::$container->get(UserPasswordEncoderInterface::class);
        $encodedPassword = $userPasswordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
        return $user;
    }

    protected function logIn(Client $client, string $email, string $password)
    {
        $client->request('POST', self::LOGIN_API, [
            'json' => [
                'email' => $email,
                'password' => $password
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }

    protected function createUserAndLogin(Client $client, string $email, string $password): UserAccount
    {
        $userAccount = $this->createUser($email, $password);
        $this->logIn($client, $email, $password);
        return $userAccount;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get(EntityManagerInterface::class);
    }
}
