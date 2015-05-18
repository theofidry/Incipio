<?php

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
