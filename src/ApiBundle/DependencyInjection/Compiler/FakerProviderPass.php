<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FakerProviderCompilerPass.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FakerProviderPass implements CompilerPassInterface
{
    const CHAIN_SERVICE = 'hautelook_alice.loader';
    const SERVICE_TAG = 'faker.provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::CHAIN_SERVICE)) {
            return;
        }
        $definition = $container->findDefinition(self::CHAIN_SERVICE);

        $taggedServices = $container->findTaggedServiceIds(self::SERVICE_TAG);
        foreach ($taggedServices as $serviceId => $tags) {
            $taggedServices[$serviceId] = new Reference($serviceId);
        }

        $definition->addMethodCall(
            'setProviders',
            [$taggedServices]
        );
    }
}
