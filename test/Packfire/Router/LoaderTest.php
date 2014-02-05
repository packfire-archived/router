<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;

class LoaderTest extends PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $loader = new Loader(__DIR__ . '/sampleRoutes.yml');
        $router = $loader->load();

        $this->assertInstanceOf('Packfire\\Router\\RouterInterface', $router);
        $this->assertEquals('/', $router->generate('home'));
    }
}
