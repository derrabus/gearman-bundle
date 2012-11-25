<?php

namespace Rabus\GearmanBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;

use Rabus\GearmanBundle\DependencyInjection\GearmanExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GearmanExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        parent::setUp();

        $this->container = $this->getContainer();
    }

    public function testSimpleWorker()
    {
        $config = array(
            'servers' => array('localhost')
        );

        $this->loadConfig($config);

        $worker = $this->container->get('gearman.worker');
        $this->assertInstanceOf('GearmanWorker', $worker);
    }

    public function testSimpleClient()
    {
        $config = array(
            'servers' => array('localhost')
        );

        $this->loadConfig($config);

        $worker = $this->container->get('gearman.client');
        $this->assertInstanceOf('GearmanClient', $worker);
    }

    /**
     * @param array $config
     */
    private function loadConfig(array $config)
    {
        $loader = new GearmanExtension;
        $loader->load(array($config), $this->container);
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        return new ContainerBuilder;
    }
}
