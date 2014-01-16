<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;

class Router implements RouterInterface, ConsumerInterface
{
    protected $routes = array();

    public function add($name, $path, $config = array())
    {
        $this->routes[$name] = compact($path, $config);
    }

    public function route(RequestInterface $request)
    {

    }

    public function generate($name, $params = array())
    {

    }

    public function __invoke($container)
    {
        
    }
}
