<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Doctrine\ORM\Manager;

use ApiBundle\Entity\Mandate;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\ORMException;

/**
 * Extends Doctrine EntityManager {@see \Doctrine\ORM\EntityManager} as the default doctrine manager, to have control
 * on unsetting relationships on deletion.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EntityManager extends EntityManagerDecorator
{
    /**
     * Factory method to create EntityManager instances.
     *
     * @param mixed         $conn         An array with the connection parameters or an existing Connection instance.
     * @param Configuration $config       The Configuration instance to use.
     * @param EventManager  $eventManager The EventManager instance to use.
     *
     * @return EntityManager The created EntityManager.
     *
     * @throws \InvalidArgumentException
     * @throws ORMException
     */
    public static function create($conn, Configuration $config, EventManager $eventManager = null)
    {
        return new self(\Doctrine\ORM\EntityManager::create($conn, $config, $eventManager));
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        // Unset relations before actually removing the user
        switch (true) {
            case $entity instanceof Mandate:
                foreach ($entity->getJobs() as $job) {
                    $job->setMandate(null);
                }
                break;
        }

        parent::remove($entity);
    }
}
