<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractDataFixtureLoader;

/**
 * Load registered fixtures.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DataLoader extends AbstractDataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__.'/job.yml',
            __DIR__.'/mandate.yml',
            __DIR__.'/user.yml',
        ];
    }
}
