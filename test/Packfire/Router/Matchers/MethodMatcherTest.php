<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use \PHPUnit_Framework_TestCase;
use Packfire\Router\CurrentRequest;
use Packfire\Router\Routes\BaseRoute;

class MethodMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $request = new CurrentRequest(
            array(
                'REQUEST_METHOD' => 'GET'
            )
        );

        $matcher = new MethodMatcher($request);

        $route = new BaseRoute(
            'test',
            array(
                'method' => array('get', 'post')
            )
        );

        $this->assertTrue($matcher->match($route));
    }

    public function testMatchFailParam()
    {
        $request = new CurrentRequest(
            array(
                'REQUEST_METHOD' => 'POST'
            )
        );

        $matcher = new MethodMatcher($request);

        $route = new BaseRoute(
            'test',
            array(
                'method' => 'get'
            )
        );

        $this->assertFalse($matcher->match($route));
    }
}
