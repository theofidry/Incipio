<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\SuiviBundle\Manager;

use Doctrine\ORM\EntityManager;

class DocTypeManager /*extends \Twig_Extension*/
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    // Pour utiliser les fonctions depuis twig
    public function getName()
    {
        return 'mgate_DocTypeManager';
    }
    // Pour utiliser les fonctions depuis twig
    public function getFunctions()
    {
        return array();
    }

    public function getRepository()
    {
        return $this->em->getRepository('mgateSuiviBundle:Etude');
    }

    public function checkSaveNewEmploye($doc)
    {
        if (!$doc->isKnownSignataire2()) {
            $doc->setSignataire2($doc->getNewSignataire2()->getPersonne());

            $doc->getNewSignataire2()->setProspect($doc->getEtude()->getProspect());
            $this->em->persist($doc->getNewSignataire2());
        }
    }
}
