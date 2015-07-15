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
use Guzzle\Common\Exception\RuntimeException;
use Guzzle\Http\Client as GuzzleClient;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * PHP API client. For now is a Guzzle client which has been extended to allow to pass route names instead of just
 * the URI and easily pass the token.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiClient extends GuzzleClient implements ApiClientInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router  Component used to generate URI from route names
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function get($uriOrRouterName = null, $token = null, $options = [])
    {
        return parent::get($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uriOrRouterName = null, $token = null, array $options = [])
    {
        return parent::head($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uriOrRouterName = null, $token = null, $body = null, array $options = array())
    {
        return parent::delete($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $body, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uriOrRouterName = null, $token = null, $body = null, array $options = array())
    {
        return parent::put($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $body, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uriOrRouterName = null, $token = null, $body = null, array $options = array())
    {
        return parent::patch($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $body, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uriOrRouterName = null, $token = null, $postBody = null, array $options = array())
    {
        return parent::post($this->getUri($uriOrRouterName), $this->extractHeaders($token, $options), $postBody, $options);
    }

    /**
     * For the API client, headers are not often set it have been removed from the most of the client functions
     * signature and have been moved in the query options. However as they are still used for the call of the Guzzle
     * client, this helper extract it form the options to return only the query headers.
     *
     * In the process the helper also set the bearer token header.
     *
     * @param string|null $token   API token
     * @param array       $options Request options
     *
     * @return array Request headers
     */
    private function extractHeaders($token = null, array &$options = [])
    {
        // Extract header from options
        $headers = [];
        if (isset($options['headers'])) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        // Add authorization token
        if (null !== $token) {
            $headers['authorization'] = sprintf('Bearer %s', $token);
        }

        return $headers;
    }

    /**
     * If the input parameter is an URI, the URI is returned unchanged. If is a route, return its matching URI.
     * 
     * @param string $uriOrRouterName
     *
     * @return string
     */
    private function getUri($uriOrRouterName)
    {
        return (false !== strpos($uriOrRouterName, '/')) ? $uriOrRouterName : $this->router->generate($uriOrRouterName);
    }
}
