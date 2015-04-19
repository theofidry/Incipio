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
//    /**
//     * Create a client with a default Authorization header.
//     *
//     * @param string $username
//     * @param string $password
//     *
//     * @return \Symfony\Bundle\FrameworkBundle\Client
//     */
//    protected function createAuthenticatedClient($username = 'user', $password = 'password')
//    {
//        $client = static::createClient();
//        $client->setServerParameter('CONTENT_TYPE', 'multipart/form-data');
//        $client->request(
//            'POST',
//            '/api/login_check',
//            [
//                'username' => $username,
//                'password' => $password,
//            ]
//        );
//
//        $data = json_decode($client->getResponse()->getContent(), true);
//
//        $client = static::createClient();
//        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
//
//        return $client;
//    }
//
//    /**
//     * @param $user
//     * @param $page
//     *
//     * @dataProvider authProvider
//     */
//    public function testGetPages($user, $page)
//    {
//        $client = $this->createAuthenticatedClient($user['username'], $user['password']);
//        $crawler = $client->request('GET', $page);
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }
//
//    /**
//     * @dataProvider userProvider
//     */
//    public function testA($user) {
//        $this->assertTrue(is_array($user));
//    }
//
//    public function authProvider()
//    {
//        $users = $this->userProvider();
//        $pages = $this->pageProvider();
//        $return = [];
//
//        foreach ($users as $argUser) {
//            foreach ($pages as $argPage) {
//                $return[] = [
//                    $argUser[0], $argPage[0]
//                ];
//            }
//        }
//
//        return $return;
//    }
//
//    public function userProvider()
//    {
//        return [
//            [
//                [
//                    'username' => 'admin',
//                    'password' => 'admin'
//                ]
//            ],
//            [
//                [
//                    'username' => 'ca',
//                    'password' => 'ca'
//                ]
//            ],
//            [
//                [
//                    'username' => 'guest',
//                    'password' => 'guest'
//                ]
//            ]
//        ];
//    }
//
//    public function pageProvider()
//    {
//        return [
//            [
//                '/api/users'
//            ]
//        ];
//    }
}
