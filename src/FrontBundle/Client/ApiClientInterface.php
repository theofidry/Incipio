<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Client;

use Guzzle\Common\Collection;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Message\RequestInterface;

/**
 * Interface ApiClientInterface.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
interface ApiClientInterface
{
    /**
     * Create a GET request for the client.
     *
     * @example
     *  ::get(users, $token, ['query' => 'filter' => 'where' => ['name' => 'john'])
     *  ::get(users, $token, ['query' => 'filter[where][name]=john'])
     *  ::get(/users?filter[where][name]=john, $token)
     *
     * Will all yield: GET /users?filter[where][name]=john
     *
     * @param string|null $uriOrRouterName URI or route name. Is considered as URI when the string starts with a  `/`
     *                                     character.
     * @param string|null $token           API token
     * @param array       $options         Options to apply to the request {@see
     *                                     Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return RequestInterface
     */
    public function get($uriOrRouterName = null, $token = null, $options = []);

    /**
     * Create a HEAD request for the client.
     *
     * @param string|null $uriOrRouterName URI or route name. Is considered as URI when the string starts with a  `/`
     *                                     character.
     * @param string|null $token           API token
     * @param array       $options         Options to apply to the request {@see
     *                                     Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return RequestInterface
     */
    public function head($uriOrRouterName = null, $token = null, array $options = []);

    /**
     * Create a DELETE request for the client.
     *
     * @param string|null                         $uriOrRouterName URI or route name. Is considered as URI when the
     *                                                             string starts with a  `/` character.
     * @param string|null                         $token           API token
     * @param string|resource|EntityBodyInterface $body            Body to send in the request
     * @param array                               $options         Options to apply to the request {@see
     *                                                             Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return EntityEnclosingRequestInterface
     */
    public function delete($uriOrRouterName = null, $token = null, $body = null, array $options = []);

    /**
     * Create a PUT request for the client.
     *
     * @param string|null                         $uriOrRouterName URI or route name. Is considered as URI when the
     *                                                             string starts with a  `/` character.
     * @param string|null                         $token           API token
     * @param string|resource|EntityBodyInterface $body            Body to send in the request
     * @param array                               $options         Options to apply to the request {@see
     *                                                             Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return EntityEnclosingRequestInterface
     */
    public function put($uriOrRouterName = null, $token = null, $body = null, array $options = []);

    /**
     * Create a PATCH request for the client.
     *
     * @param string|null                         $uriOrRouterName URI or route name. Is considered as URI when the
     *                                                             string starts with a  `/` character.
     * @param string|null                         $token           API token
     * @param string|resource|EntityBodyInterface $body            Body to send in the request
     * @param array                               $options         Options to apply to the request {@see
     *                                                             Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return EntityEnclosingRequestInterface
     */
    public function patch($uriOrRouterName = null, $token = null, $body = null, array $options = []);

    /**
     * Create a PATCH request for the client.
     *
     * @param string|null                                 $uriOrRouterName URI or route name. Is considered as URI when
     *                                                                     the string starts with a  `/` character.
     * @param string|null                                 $token           API token
     * @param array|Collection|string|EntityBodyInterface $postBody        POST body. Can be a string, EntityBody, or
     *                                                                     associative array of POST fields to send in
     *                                                                     the body of the request. Prefix a value in
     *                                                                     the array with the @ symbol to reference a
     *                                                                     file.
     * @param array                                       $options         Options to apply to the request {@see
     *                                                                     Guzzle\Http\Message\RequestFactoryInterface::applyOptions()}
     *
     * @return EntityEnclosingRequestInterface
     */
    public function post($uriOrRouterName = null, $token = null, $postBody = null, array $options = []);
}
