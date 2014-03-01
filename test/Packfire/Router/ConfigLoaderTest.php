<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;
use Packfire\FuelBlade\Container;
use Packfire\Config\ConfigFactory;

class ConfigLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $factory = new ConfigFactory();
        $config = $factory->load(__DIR__ . '/sampleRoutes.yml');
        $loader = new ConfigLoader($config);
        $resultRouter = $loader->load();

        $this->assertInstanceOf('Packfire\\Router\\RouterInterface', $resultRouter);
        $this->assertEquals('/', $resultRouter->generate('home'));
    }

    public function testLoad2()
    {
        $router = $this->getMock('Packfire\\Router\\RouterInterface');
        $router->expects($this->exactly(2))
            ->method('add');

        $container = new Container();
        $container['Packfire\\Router\\RouterInterface'] = $router;

        $factory = new ConfigFactory();
        $config = $factory->load(__DIR__ . '/sampleRoutes.yml');

        $loader = $container->instantiate('Packfire\\Router\\ConfigLoader', array('config' => $config));
        $resultRouter = $loader->load();

        $this->assertInstanceOf('Packfire\\Router\\RouterInterface', $resultRouter);
    }

    public function testLoad3()
    {
        $router = $this->getMock('Packfire\\Router\\RouterInterface');
        $router->expects($this->exactly(2))
            ->method('add');

        $factory = new ConfigFactory();
        $config = $factory->load(__DIR__ . '/sampleRoutes.yml');
        $loader = new ConfigLoader($config);
        $resultRouter = $loader->load($router);

        $this->assertInstanceOf('Packfire\\Router\\RouterInterface', $resultRouter);
        $this->assertEquals($router, $resultRouter);
    }
}
