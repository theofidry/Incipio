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
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\ORMException;

/**
 * Extends Doctrine EntityManager {@see \Doctrine\ORM\EntityManager} as the default doctrine manager, to have control
 * on unsetting relationships on deletion.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EntityManager extends DoctrineEntityManager
{
    /**
     * {@inheritdoc}
     */
    public static function create($conn, Configuration $config, EventManager $eventManager = null)
    {
        // Block of the parent class
        if ( ! $config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        switch (true) {
            case (is_array($conn)):
                $conn = DriverManager::getConnection(
                    $conn, $config, ($eventManager ?: new EventManager())
                );
                break;

            case ($conn instanceof Connection):
                if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                    throw ORMException::mismatchedEventManager();
                }
                break;

            default:
                throw new \InvalidArgumentException("Invalid argument: " . $conn);
        }
        // End of block

        // Overridden part: return an instance of this entity manager instead of Doctrine one
        return new EntityManager($conn, $config, $conn->getEventManager());
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
