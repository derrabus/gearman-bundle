<?php

namespace Rabus\GearmanBundle\Tests\DependencyInjection;

use GearmanClient, GearmanWorker;
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
        /** @var GearmanWorker $worker */
        $this->assertEquals(-1, $worker->timeout());
    }

    public function testSimpleClient()
    {
        $config = array(
            'servers' => array('localhost')
        );

        $this->loadConfig($config);

        $client = $this->container->get('gearman.client');
        $this->assertInstanceOf('GearmanClient', $client);
        /** @var GearmanClient $client */
        $this->assertEquals(-1, $client->timeout());
    }

    public function testWorkerWithTimeout()
    {
        $config = array(
            'servers' => array('localhost'),
            'timeout' => 5000
        );

        $this->loadConfig($config);

        $worker = $this->container->get('gearman.worker');
        $this->assertInstanceOf('GearmanWorker', $worker);
        /** @var GearmanWorker $worker */
        $this->assertEquals(5000, $worker->timeout());
    }

    public function testClientWithTimeout()
    {
        $config = array(
            'servers' => array('localhost'),
            'timeout' => 5000
        );

        $this->loadConfig($config);

        $client = $this->container->get('gearman.client');
        $this->assertInstanceOf('GearmanClient', $client);
        /** @var GearmanClient $client */
        $this->assertEquals(5000, $client->timeout());
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
