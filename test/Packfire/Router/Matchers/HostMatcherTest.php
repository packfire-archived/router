<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use \PHPUnit_Framework_TestCase;
use Packfire\Router\CurrentRequest;
use Packfire\Router\Routes\BaseRoute;

class HostMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $request = new CurrentRequest(
            array(
                'HTTP_HOST' => 'blog.heartcode.sg'
            )
        );

        $matcher = new HostMatcher($request);

        $route = new BaseRoute(
            'test',
            array(
                'host' => '*.heartcode.sg'
            ),
            array()
        );

        $this->assertTrue($matcher->match($route));
    }

    public function testRegexCompiler()
    {
        $this->assertEquals('`[a-z0-9]+\.heartcode\.sg`i', HostMatcher::regexCompiler('*.heartcode.sg'));
    }
}
