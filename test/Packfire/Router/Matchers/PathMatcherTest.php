<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use \PHPUnit_Framework_TestCase;
use Packfire\Router\CurrentRequest;
use Packfire\Router\Routes\BaseRoute;

class PathMatcherTest extends PHPUnit_Framework_TestCase
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
                'path' => '/test/example/:id(.:format?)',
                'params' => array(
                    'id' => 'i'
                )
            )
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
                'path' => '/test/example/:id(.:format?)',
                'params' => array(
                    'id' => 'i'
                )
            )
        );

        $this->assertFalse($matcher->match($route));
    }

    public function testValidate()
    {
        $this->assertTrue(PathMatcher::validate(array('v' => 1), 'v', 'i'));
        $this->assertTrue(PathMatcher::validate(array('v' => '2'), 'v', 'integer'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'ag'), 'v', 'i'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'gf2'), 'v', 'integer'));

        $this->assertTrue(PathMatcher::validate(array('v' => 'alph'), 'v', 'a'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'test'), 'v', 'alpha'));
        $this->assertFalse(PathMatcher::validate(array('v' => '5425'), 'v', 'a'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'test43'), 'v', 'alpha'));

        $this->assertTrue(PathMatcher::validate(array('v' => 'an123'), 'v', 'an'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'hope092'), 'v', 'alnum'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'sam'), 'v', 'alphanumeric'));
        $this->assertTrue(PathMatcher::validate(array('v' => 1544), 'v', 'an'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'an1@23'), 'v', 'an'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'hope 92'), 'v', 'alnum'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'sam?'), 'v', 'alphanumeric'));
        $this->assertFalse(PathMatcher::validate(array('v' => '1544!'), 'v', 'an'));

        $this->assertTrue(PathMatcher::validate(array('v' => 'maybe-134'), 'v', 's'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'test-134-unit-cool'), 'v', 'slug'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'ma!ybe-134'), 'v', 's'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'test-134-uni t-cool'), 'v', 'slug'));

        $this->assertTrue(PathMatcher::validate(array('v' => 'A04F32BC'), 'v', 'h'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'ce413f'), 'v', 'hex'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'A0GF2BC'), 'v', 'h'));
        $this->assertFalse(PathMatcher::validate(array('v' => 'ce41RW3f'), 'v', 'hex'));

        $this->assertTrue(PathMatcher::validate(array('v' => 'words 123?'), 'v', 'any'));
        $this->assertTrue(PathMatcher::validate(array('v' => 'test maybe, 123?'), 'v', 'text'));

        $this->assertTrue(PathMatcher::validate(array('v' => '123'), 'v', '[1-3]+'));
        $this->assertFalse(PathMatcher::validate(array('v' => '4552'), 'v', '[1-3]+'));
    }
}
