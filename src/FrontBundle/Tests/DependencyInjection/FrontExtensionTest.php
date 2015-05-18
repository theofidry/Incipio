<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Tests\DependencyInjection;

use FrontBundle\DependencyInjection\FrontExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class FrontExtensionTest.
 *
 * @coversDefaultClass FrontBundle\DependencyInjection\FrontExtension
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class FrontExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Ensure that the Bundle extension load properly.
     *
     * @covers ::load
     */
    public function testLoading()
    {
        $this->load();
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new FrontExtension(),
        );
    }
}
