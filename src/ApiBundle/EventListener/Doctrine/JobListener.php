<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\EventListener\Doctrine;

use ApiBundle\Manager\NonPersistentEntityManagerInterface;
use ApiBundle\Entity\Job;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JobListener
{
    /**
     * @var NonPersistentEntityManagerInterface
     */
    private $manager;

    /**
     * @param NonPersistentEntityManagerInterface $manager
     *
     * @throws \InvalidArgumentException If the manager does not supports the entity manipulated.
     */
    public function __construct(NonPersistentEntityManagerInterface $manager)
    {
        if (false === $manager->supports(Job::class)) {
            throw new \InvalidArgumentException(
                sprintf('The manager %s does not support %s objects.', get_class($manager), Job::class)
            );
        }

        $this->manager = $manager;
    }

    public function preFlush(Job $job, PreFlushEventArgs $args)
    {
        $this->manager->update($job);
    }

    public function preRemove(Job $job, LifecycleEventArgs $event)
    {
        $this->manager->remove($job);
    }
}
