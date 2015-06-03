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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardController.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DashboardController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="dashboard")
     *
     * @Method("GET")
     * @Template("FrontBundle::dashboard.html.twig")
     *
     * @return Response
     */
    public function indexAction()
    {
        return [];
    }
}
