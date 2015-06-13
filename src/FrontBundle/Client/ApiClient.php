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

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class ApiClient.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiClient extends Client
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Set client router. Is Used for generating URI from routes name.
     *
     * @param Router $router
     *
     * @return $this
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

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
     * @param string $name    URI or route name. Is considered as URI when a `/` is present
     * @param string $token   API token.
     * @param array  $options Options to apply to the request. For BC compatibility, you can also pass a string to tell
     *                        Guzzle to download the body of the response to a particular location. Use the 'body'
     *                        option instead for forward compatibility. If you wish to apply custom headers, place them
     *                        in a `headers` key of the $options.
     *                        Options can also take query parameters as a string for
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function get($name = null, $token = null, $options = [])
    {
        // Extract header from options
        $headers = [];
        if (array_key_exists('headers', $options)) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        // Add authorization token
        $headers['authorization'] = sprintf('Bearer %s', $token);

        // Get URI
        $uri = (false !== strpos($name, '/')) ? $name : $this->router->generate($name);

        // Check for query parameters
        if (isset($options['query']) && is_string($options['query'])) {
            $uri .= (false !== strpos($uri, '?'))? '&': '?';
            $uri .= $options['query'];
            unset($options['query']);
        }

        return parent::get($uri, $headers, $options);
    }

    //TODO: other methods
}
