<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Controller;

use FrontBundle\Client\ApiClientInterface;
use FrontBundle\Utils\IriHelper;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\RequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BaseController.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class BaseController extends Controller implements ApiControllerInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $client;

    /**
     * @var SerializerInterface|NormalizerInterface|DecoderInterface
     */
    protected $serializer;

    /**
     * {@inheritdoc}
     */
    public function generateUrl($route, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (array_key_exists('id', $parameters)) {
            $parameters['id'] = IriHelper::extractId($parameters['id']);
        }

        return parent::generateUrl($route, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, array $context = [])
    {
        $this->serializer->decode($data, 'json', $context);
    }

    /**
     * {@inheritdoc}
     */
    public function requestAndDecode($method, $url = null, $token = null, $options = [])
    {
        if ($token instanceof Request) {
            $token = $token->getSession()->get('api_token');
        }

        return $this->decode($this->client->request($method, $url, $token, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function sendAndDecode(RequestInterface $request)
    {
        return $this->decode($this->client->send($request));
    }


    /**
     * {@inheritdoc}
     *
     * @deprecated Should return an array with @template instead. {@link
     *             http://symfony.com/fr/doc/current/bundles/SensioFrameworkExtraBundle/annotations/view.html}
     */
    public function renderView($view, array $parameters = [])
    {
        return parent::renderView($view, $parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Should return an array with @template instead. {@link
     *             http://symfony.com/fr/doc/current/bundles/SensioFrameworkExtraBundle/annotations/view.html}
     */
    public function render($view, array $parameters = [], Response $response = null)
    {
        return parent::render($view, $parameters, $response);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Should not have to use Doctrine.
     * @throws     \LogicException If used.
     */
    public function getDoctrine()
    {
        throw new \LogicException('The DoctrineBundle should not be used in the Front application.');
    }
}
