<?php

namespace ApiBundle\Bundles\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/api/login")
     */
    public function loginApiAction(Request $request)
    {
        $csrfToken = $this->has('form.csrf_provider')
            ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return new JsonResponse(['csrf_token' => $csrfToken]);
    }
}
