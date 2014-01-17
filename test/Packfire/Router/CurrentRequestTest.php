<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use \PHPUnit_Framework_TestCase;

class CurrentRequestTest extends PHPUnit_Framework_TestCase
{
    public function testPath()
    {
        $server = array(
            'ORIG_PATH_INFO' => '/test/example/10'
        );
        $request = new CurrentRequest($server);
        $this->assertEquals($server['ORIG_PATH_INFO'], $request->path());
        $this->assertNull($request->host());
        $this->assertNull($request->method());
    }
}
