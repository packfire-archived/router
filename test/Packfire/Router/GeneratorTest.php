<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;
use Packfire\Router\Routes\BaseRoute;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $route = new BaseRoute(
            'test',
            array(
                'path' => '/test/example/:id(.:format?)',
                'params' => array(
                    'id' => 'i'
                )
            )
        );

        $generator = new Generator();

        $uri = $generator->generate($route, array('id' => 4));
        $this->assertEquals('/test/example/4', $uri);
    }

    public function testGenerate2()
    {
        $route = new BaseRoute(
            'test',
            array(
                'path' => '/test/example/:id(.:format?)',
                'params' => array(
                    'id' => 'i'
                )
            )
        );

        $generator = new Generator();

        $uri = $generator->generate($route, array('id' => 4, 'format' => 'json'));
        $this->assertEquals('/test/example/4.json', $uri);
    }

    public function testGenerateNothing()
    {
        $route = new BaseRoute(
            'test',
            array(
            )
        );

        $generator = new Generator();

        $uri = $generator->generate($route, array('id' => 4, 'format' => 'json'));
        $this->assertNull($uri);
    }

    /**
     * @expectedException Packfire\Router\Exceptions\MissingRequiredParameterException
     */
    public function testGenerateFailRequiredParam()
    {
        $route = new BaseRoute(
            'test',
            array(
                'path' => '/test/example/:id(.:format?)',
                'params' => array(
                    'id' => 'i'
                )
            )
        );

        $generator = new Generator();

        $uri = $generator->generate($route, array('format' => 'json'));
    }
}
