<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction() {

        return $this->render('FrontBundle:Default:layout.html.twig');
    }
}
