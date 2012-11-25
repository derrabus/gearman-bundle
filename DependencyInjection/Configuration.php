<?php

namespace Rabus\GearmanBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $root = $builder->root('gearman');

        $root->children()->arrayNode('servers')->prototype('scalar')->isRequired();

        return $builder;
    }
}
