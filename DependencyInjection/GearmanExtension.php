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

        $this->configureDefinition($workerDefinition, $mergedConfig);
        $this->configureDefinition($clientDefinition, $mergedConfig);

        $container->setDefinition('gearman.worker', $workerDefinition);
        $container->setDefinition('gearman.client', $clientDefinition);
    }

    /**
     * @param Definition $definition
     * @param array $config
     */
    private function configureDefinition(Definition $definition, array $config)
    {
        foreach ($config['servers'] as $currentServer) {
            $currentServer = explode(':', $currentServer, 2);
            $definition->addMethodCall('addServer', $currentServer);
        }
        $definition->addMethodCall('setTimeout', array($config['timeout']));
        $definition->setScope('prototype');
    }
}
