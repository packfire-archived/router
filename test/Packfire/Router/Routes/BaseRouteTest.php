<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use \PHPUnit_Framework_TestCase;

class PathMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testTestConfig()
    {
        $this->assertTrue(BaseRoute::testConfig(array('path' => '/test', 'action' => 'TestController::imagine')));
        $this->assertFalse(BaseRoute::testConfig(array('path' => '/test')));
        $this->assertFalse(BaseRoute::testConfig(array('action' => 'TestController::imagine')));
    }
}
