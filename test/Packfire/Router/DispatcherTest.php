<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testDispatch()
    {
        $dispatcher = new Dispatcher();
        $result = $dispatcher->dispatch(
            function ($a, $b) {
                return $a + $b;
            },
            array(
                'b' => 3,
                'a' => 2
            )
        );
        $this->assertEquals(5, $result);
    }

    public function testDispatch2()
    {
        $dispatcher = new Dispatcher();
        $result = $dispatcher->dispatch(
            array('Packfire\\Router\\DispatcherTest', 'func'),
            array(
                'b' => 3,
                'a' => 2
            )
        );
        $this->assertEquals(5, $result);
    }

    public function testDispatch3()
    {
        $dispatcher = new Dispatcher();
        $result = $dispatcher->dispatch(
            array($this, 'func'),
            array(
                'b' => 3,
                'a' => 2
            )
        );
        $this->assertEquals(5, $result);
    }

    public static function func($a, $b)
    {
        return $a + $b;
    }

    public function func2($a, $b)
    {
        return $a + $b;
    }
}
