<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('mgateDashboardBundle:Default:index.html.twig');
    }

    public function navbarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.context')->getToken()->getUser()->getPersonne();

        //Etudes Suiveur
        $etudesSuiveur = array();
        foreach ($em->getRepository('mgateSuiviBundle:Etude')->findBy(array('suiveur' => $user), array('mandat' => 'DESC', 'id' => 'DESC')) as $etude) {
            $stateID = $etude->getStateID();
            if ($stateID <= 2) {
                array_push($etudesSuiveur, $etude);
            }
        }

        return $this->render('mgateDashboardBundle:Navbar:layout.html.twig', array('etudesSuiveur' => $etudesSuiveur));
    }
}
