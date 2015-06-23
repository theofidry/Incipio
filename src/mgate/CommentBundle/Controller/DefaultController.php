<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('mgateCommentBundle:Default:index.html.twig', array('name' => $name));
    }

    public function maintenanceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $etudes = $em->getRepository('mgateSuiviBundle:Etude')->findAll();

        foreach ($etudes as $entity) {
            if (!$em->getRepository('mgateCommentBundle:Thread')->findBy(array('id' => $entity))) {
                $this->container->get('mgate_comment.thread')->creerThread('etude_', $this->container->get('router')->generate('mgatePersonne_prospect_voir', array('id' => $entity->getId())), $entity);
            }
        }

        return $this->render('mgateCommentBundle:Default:index.html.twig', array('name' => 'rien'));
    }
}
