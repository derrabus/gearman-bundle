<?php

namespace Rabus\GearmanBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class GearmanExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $workerDefinition = new Definition('GearmanWorker');
        $clientDefinition = new Definition('GearmanClient');

        foreach ($mergedConfig['servers'] as $currentServer) {
            $currentServer = explode(':', $currentServer, 2);
            $workerDefinition->addMethodCall('addServer', $currentServer);
            $clientDefinition->addMethodCall('addServer', $currentServer);
        }

        $workerDefinition->setScope('prototype');

        $container->setDefinition('gearman.worker', $workerDefinition);
        $container->setDefinition('gearman.client', $clientDefinition);
    }
}
