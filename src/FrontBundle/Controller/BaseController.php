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
use GuzzleHttp\Message\RequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        $this->client = $this->get('api.client');
        $this->serializer = $this->get('serializer');
    }


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
        return $this->serializer->decode($data, JsonEncoder::FORMAT, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function requestAndDecode($method, $url = null, $token = null, $options = [], $wholeCollection = false)
    {
        if ($token instanceof Request) {
            $token = $token->getSession()->get('api_token');
        }

        $request = $this->client->createRequest($method, $url, $token, $options);

        if ($token instanceof RequestInterface) {
            $request->setHeader('authorization', $token->getHeader('authorization'));
        }

        return $this->sendAndDecode($request, $wholeCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function sendAndDecode(RequestInterface $request, $wholeCollection = false)
    {
        $decodedResponse = $this->decode($this->client->send($request)->getBody());

        if (false === $wholeCollection) {
            return $decodedResponse;
        }

        return $this->getEntitiesFromCollection(
            $decodedResponse,
            $request
        );
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

    /**
     * Helper to retrieve all resources from a paginated collection. If the decoded response is not a collection,
     * will return the decoded response.
     *
     * @param array $decodedResponse
     * @param Request|string|null  $token
     *
     * @return array Decoded response or all entities of the paginated collection.
     */
    private function getEntitiesFromCollection(array $decodedResponse, $token = null)
    {
        if ('hydra:PagedCollection' !== $decodedResponse['@type']) {
            return $decodedResponse;
        }

        $resources = [$decodedResponse['hydra:member']];
        while (isset($decodedResponse['hydra:nextPage'])) {
            $decodedResponse = $this->requestAndDecode(
                'GET',
                $decodedResponse['hydra:nextPage'],
                $token
            );

            $resources[] = $decodedResponse['hydra:member'];
        }

        return call_user_func_array('array_merge', $resources);
    }
}
