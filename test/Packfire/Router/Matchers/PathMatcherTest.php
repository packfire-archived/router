<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use \PHPUnit_Framework_TestCase;
use Packfire\Router\CurrentRequest;
use Packfire\Router\Routes\BaseRoute;

class PatchMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $request = new CurrentRequest(
            array(
                'SCRIPT_NAME' => '/index.php',
                'PHP_SELF' => '/index.php/test/example/10.xml'
            )
        );

        $matcher = new PathMatcher($request);

        $route = new BaseRoute(
            'test',
            array(
                'path' => array(
                    'uri' => '/test/example/:id(.:format?)',
                    'params' => array(
                        'id' => 'i'
                    )
                )
            ),
            array()
        );

        $this->assertTrue($matcher->match($route));
        $this->assertEquals(array('id' => 10), $matcher->params());
    }

    public function testMatchFailParam()
    {
        $request = new CurrentRequest(
            array(
                'SCRIPT_NAME' => '/index.php',
                'PHP_SELF' => '/index.php/test/example/woah.xml'
            )
        );

        $matcher = new PathMatcher($request);

        $route = new BaseRoute(
            'test',
            array(
                'path' => array(
                    'uri' => '/test/example/:id(.:format?)',
                    'params' => array(
                        'id' => 'i'
                    )
                )
            ),
            array()
        );

        $this->assertFalse($matcher->match($route));
    }
}
