<?php


namespace App\OpenApi;


use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    /**
     * OpenApiFactory constructor.
     */
    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }


    /**
     * @inheritDoc
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Login'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'example@example.com'
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'qwerty123'
                ]
            ]
        ]);

        $schemas['LoginResponse'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'error' => [
                    'type' => 'string',
                    'example' => 'Invalid credentials'
                ]
            ]
        ]);

        $loginPathItem = new PathItem(
            'Login',
            '',
            '',
            NULL,
            NULL,
            new Operation(
                'loginUser',
                ['users'],
                [
                    '204' => [
                        'description' => 'Logged in successfully'
                    ],
                    '401' => [
                        'description' => 'Invalid credentials',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/LoginResponse'
                                ]
                            ]
                        ]
                    ]
                ],
                'Begin new session for user',
                '',
                NULL,
                [],
                new RequestBody(
                    'Get session cookie to login',
                    new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Login'
                            ]
                        ]
                    ])
                )
            )
        );

        $logoutPathItem = new PathItem(
            'Logout',
            '',
            '',
            new Operation(
                'logoutUser',
                ['users'],
                [
                    '302' => [
                        'description' => 'Logged out successfully'
                    ]
                ],
                'End session for user'
            )
        );

        $openApi->getPaths()->addPath('/login', $loginPathItem);
        $openApi->getPaths()->addPath('/logout', $logoutPathItem);

        return $openApi;
    }
    
}
