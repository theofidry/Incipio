<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class MandateController.
 *
 * @Route("/test")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class MandateController extends Controller
{
    /**
     * @Route("/", name="test")
     *
     * @Method("GET")
     */
    public function currentAction()
    {
        $test = $this->getDoctrine()->getManager()->getRepository('ApiBundle:Mandate')->findCurrent();

        dump($test);die();
    }
}
