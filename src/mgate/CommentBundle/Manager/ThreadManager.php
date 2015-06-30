<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\CommentBundle\Manager;

use FOS\CommentBundle\Acl\AclThreadManager as FOSthread;
use Doctrine\ORM\EntityManager;
use mgate\CommentBundle\Entity\Thread as mgateThread;

class ThreadManager
{
    protected $tm;
    protected $em;

    public function __construct(FOSthread $threadManager, EntityManager $entitymanager)
    {
        $this->tm = $threadManager;
        $this->em = $entitymanager;
    }

    public function creerThread($name, $permaLink, $entity)
    {
        if (!$entity->getThread()) {

            //get('fos_comment.manager.thread')
            //$thread = new mgateThread;

            $thread = $this->tm->createThread($name.$entity->getId());
            //$thread->setId($name.$entity->getId());
            //$thread->setPermalink( $permaLink );
            $entity->setThread($thread);
            //$this->em->persist($thread);

            $this->em->flush();
        }
    }
}
