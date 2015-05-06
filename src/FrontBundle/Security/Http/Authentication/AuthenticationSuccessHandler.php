<?php

namespace FrontBundle\Security\Http\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * Class AuthenticationSuccessListener: class with the default authentication success handling logic.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * @var JWTManager
     */
    private $jwtManager;

    /**
     * Constructor.
     *
     * @param HttpUtils  $httpUtils
     * @param JWTManager $jwtManager
     * @param array      $options    Options for processing a successful authentication attempt.
     */
    public function __construct(HttpUtils $httpUtils, JWTManager $jwtManager, array $options = [])
    {
        parent::__construct($httpUtils, $options);

        $this->jwtManager = $jwtManager;
    }

    /**
     * {@inheritdoc}
     *
     * Overrides event to add API token to the user's session.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user     = $token->getUser();
        $apiToken = $this->jwtManager->create($user);

        $request->getSession()->set('api_token', $apiToken);

        return parent::onAuthenticationSuccess($request, $token);
    }
}
