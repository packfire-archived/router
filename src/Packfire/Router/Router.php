<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

class Router
{
    protected $routes = array();

    public function add($name, $route, $options = array())
    {
        $this->routes[$name] = compact($route, $options);
    }

    public function route($request)
    {

    }

    public function generate($name, $params = array())
    {

    }
}
