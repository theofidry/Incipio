<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Tests\Client;

use FrontBundle\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Since the client heavily relies on Guzzle client, we only tests the added functionalities which are the token
 * handling and the generation of request via the route name instead of only the URI.
 *
 * @coversDefaultClass FrontBundle\Client\ApiClient
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiClientTest extends KernelTestCase
{
    /**
     * @var ApiClient
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->service = self::$kernel->getContainer()->get('api.client');
    }

    /**
     * @testdox Check that the overridden methods generates the expected request
     *
     * @covers ::get
     * @covers ::head
     * @covers ::delete
     * @covers ::put
     * @covers ::patch
     * @covers ::post
     * @covers ::extractHeaders
     *
     * @dataProvider getMethodProvider
     *
     * @param string $uriOrRouteName
     * @param bool   $token
     * @param array  $options
     * @param string $expectedUrl
     */
    public function testOverriddenMethod($uriOrRouteName, $token, $options, $expectedUrl)
    {
        $tokenValue = (true === $token)? 'MyToken': null;

        $requests = [
            'get'    => $this->service->get($uriOrRouteName, $tokenValue, $options),
            'head'   => $this->service->head($uriOrRouteName, $tokenValue, $options),
            'delete' => $this->service->delete($uriOrRouteName, $tokenValue, null, $options),
            'put'    => $this->service->put($uriOrRouteName, $tokenValue, null, $options),
            'patch'  => $this->service->patch($uriOrRouteName, $tokenValue, null, $options),
            'post'   => $this->service->post($uriOrRouteName, $tokenValue, null, $options),
        ];

        foreach ($requests as $request) {
            $this->assertEquals(
                sprintf('http://localhost%s', $expectedUrl),
                $request->getUrl()
            );

            $headerCount = 2;
            if (null !== $tokenValue) {
                $this->assertTrue($request->getHeader('authorization')->hasValue('Bearer MyToken'));
                $headerCount++;
            }

            if (isset($options['headers'])) {
                foreach ($options['headers'] as $header => $value) {
                    $this->assertTrue($request->getHeader($header)->hasValue($value));
                }
                $headerCount += count($options['headers']);
            }

            $this->assertEquals($headerCount, count($request->getHeaders()));
        }
    }

    public function getMethodProvider()
    {
        return [
            // route name
            // no token
            // no options
            [
                'users_cget',
                false,
                [],
                '/api/users',
            ],
            // route name
            // no token
            // options
            [
                'users_cget',
                false,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test',
            ],

            // route name
            // token
            // no options
            [
                'users_cget',
                true,
                [],
                '/api/users',
            ],
            // route name
            // token
            // options
            [
                'users_cget',
                true,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test',
            ],

            // URI
            // no token
            // no options
            [
                '/api/users',
                false,
                [],
                '/api/users',
            ],
            // URI
            // no token
            // options
            [
                '/api/users',
                false,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test',
            ],

            // URI
            // token
            // no options
            [
                '/api/users',
                true,
                [],
                '/api/users',
            ],
            // URI
            // token
            // options
            [
                '/api/users',
                true,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test',
            ],

            // URI with params
            // no token
            // no options
            [
                '/api/users?lol',
                false,
                [],
                '/api/users?lol',
            ],
            // URI with params
            // no token
            // options
            [
                '/api/users?lol',
                false,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test&lol',
            ],

            // URI with params
            // token
            // no options
            [
                '/api/users?lol',
                true,
                [],
                '/api/users?lol',
            ],
            // URI with params
            // token
            // options
            [
                '/api/users?lol',
                true,
                [
                    'query'   => ['random' => 'test'],
                    'headers' => ['Foo' => 'Bar', 'Baz' => 'Bam'],
                ],
                '/api/users?random=test&lol',
            ],
        ];
    }
}
