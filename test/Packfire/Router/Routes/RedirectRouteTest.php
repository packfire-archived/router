<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use \PHPUnit_Framework_TestCase;
use Packfire\FuelBlade\Container;

function header($header, $replacement = false, $code = null)
{
    echo json_encode(func_get_args());
}

class RedirectRouteTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $container = new Container();
        $container['PHPUnit_Framework_TestCase'] = $this;

        $config = array(
            'path' => '/blog',
            'target' => 'http://blog.example.com'
        );
        $route = $container->instantiate('Packfire\\Router\\Routes\\RedirectRoute', array('name' => 'test', 'config' => $config));

        ob_start();
        $route->execute();
        $content = ob_get_contents();
        ob_end_clean();
        $var = json_decode($content, true);
        $this->assertEquals(array('Location: http://blog.example.com', true, 302), $var);
    }
}
