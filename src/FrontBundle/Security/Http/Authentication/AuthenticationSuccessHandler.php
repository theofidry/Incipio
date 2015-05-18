<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Security\Http\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;

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
     * Set JwtManager.
     *
     * @param JWTManager $jwtManager
     *
     * @return $this
     */
    public function setJwtManager(JWTManager $jwtManager)
    {
        $this->jwtManager = $jwtManager;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * Overrides event to add API token to the user's session.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $apiToken = $this->jwtManager->create($user);

        $request->getSession()->set('api_token', $apiToken);

        return parent::onAuthenticationSuccess($request, $token);
    }
}
