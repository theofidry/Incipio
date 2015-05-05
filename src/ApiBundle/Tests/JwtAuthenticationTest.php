<?php

namespace ApiBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class JwtAuthenticationTest.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JwtAuthenticationTest extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     *
     * @throws \Exception Thrown if could not get token.
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->setServerParameter('CONTENT_TYPE', 'multipart/form-data');
        $client->request(
            'POST',
            '/api/login_check',
            [
                'username' => $username,
                'password' => $password,
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);
        if (false === array_key_exists('token', $data)) {
            throw new \Exception('Expected token in the response.');
        }

        $client->getContainer()->get('session')->set('_security_main', serialize($token));

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * @param $user
     * @param $page
     *
     * @dataProvider authProvider
     */
    public function testGetPages($user, $page)
    {
        $client = $this->createAuthenticatedClient($user['username'], $user['password']);
        $crawler = $client->request('GET', $page);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function authProvider()
    {
        $users = $this->userProvider();
        $pages = $this->pageProvider();
        $return = [];

        foreach ($users as $argUser) {
            foreach ($pages as $argPage) {
                $return[] = [
                    $argUser[0],
                    $argPage[0],
                ];
            }
        }

        return $return;
    }

    /**
     * @return array List of users.
     */
    public function userProvider()
    {
        return [
            [
                [
                    'username' => 'admin',
                    'password' => 'admin',
                ],
            ],
            [
                [
                    'username' => 'ca',
                    'password' => 'ca',
                ],
            ],
            [
                [
                    'username' => 'guest',
                    'password' => 'guest',
                ],
            ],
        ];
    }

    /**
     * @return array List of pages.
     */
    public function pageProvider()
    {
        return [
            ['/api/'],
            ['/api/contexts/Entrypoint'],
            ['/api/vocab'],
            ['/api-doc/'],
        ];
    }
}
