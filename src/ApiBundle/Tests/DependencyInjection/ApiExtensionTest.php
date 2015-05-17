<?php

namespace ApiBundle\Tests\DependencyInjection;

use ApiBundle\DependencyInjection\ApiExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class ApiExtensionTest.
 *
 * @coversDefaultClass ApiBundle\DependencyInjection\ApiExtension
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiExtensionTest extends AbstractExtensionTestCase
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
            new ApiExtension(),
        );
    }
}
