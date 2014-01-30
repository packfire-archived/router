<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testRoute()
    {
        $config = array(
            'path' => '/test',
            'target' => 'http://heartcode.sg/'
        );

        $router = new Router();
        $router->add('test', $config);

        $request = new CurrentRequest(
            array(
                'SCRIPT_NAME' => '/index.php',
                'PHP_SELF' => '/index.php/test'
            )
        );

        $route = $router->route($request);
        $this->assertInstanceOf('Packfire\\Router\\RouteInterface', $route);
        $this->assertEquals('test', $route->name());
    }

    public function testRouteMatchMany()
    {
        $router = new Router();

        $config = array(
            'path' => '/test',
            'target' => 'http://heartcode.sg/'
        );
        $router->add('test', $config);

        $config = array(
            'path' => '/blog-:id',
            'target' => 'http://heartcode.sg/'
        );
        $router->add('blog', $config);

        $request = new CurrentRequest(
            array(
                'SCRIPT_NAME' => '/index.php',
                'PHP_SELF' => '/index.php/blog-5'
            )
        );

        $route = $router->route($request);
        $this->assertInstanceOf('Packfire\\Router\\RouteInterface', $route);
        $this->assertEquals('blog', $route->name());
    }


    public function testGenerate()
    {
        $config = array(
            'path' => '/blog/:id',
            'target' => 'http://heartcode.sg/'
        );

        $router = new Router();
        $router->add('test', $config);

        $uri = $router->generate('test', array('id' => 5));
        $this->assertEquals('/blog/5', $uri);
    }

    /**
     * @exceptedException Packfire\Router\Exceptions\RouteNotFoundException
     */
    public function testGenerateException()
    {
        $config = array(
            'path' => '/blog/:id',
            'target' => 'http://heartcode.sg/'
        );

        $router = new Router();
        $router->add('one', $config);
    }
}
