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
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

/**
 * Class DataLoader: register faker providers and load registered fixtures.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DataLoader extends DataFixtureLoader
{
    /**
     * {inheritDoc}.
     *
     * TODO: do not override this method. This is done as a temporary measure for adding custom providers. To check
     * the updates on the subject, check the following link. Currently overrided loader to not change the loader's
     * providers
     *
     * @link https://github.com/hautelook/AliceBundle/issues/46
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        /** @var $loader \Hautelook\AliceBundle\Alice\Loader */
        $loader = $this->container->get('hautelook_alice.loader');
        $loader->setObjectManager($manager);

        foreach ($this->getProcessors() as $processor) {
            $loader->addProcessor($processor);
        }

        $loader->load($this->getFixtures());

        return $loader->getReferences();
    }

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
