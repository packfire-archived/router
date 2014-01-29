<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;
use Packfire\FuelBlade\Container;

class RouteFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $config = array(
            'path' => '/test',
            'target' => 'http://heartcode.sg/'
        );

        $container = new Container();
        $factory = $container->instantiate('Packfire\\Router\\RouteFactory');
        $obj = $factory->create('test', $config);

        $this->assertInstanceOf('Packfire\\Router\\Routes\\RedirectRoute', $obj);
    }
}
