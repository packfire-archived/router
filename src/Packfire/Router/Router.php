<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\FuelBlade\Container;

class Router implements RouterInterface, ConsumerInterface
{
    protected $routes = array();

    protected $container;

    protected $factory;

    public function __construct()
    {
        $this->container = new Container();
        $this->factory = $this->container->instantiate('Packfire\\Router\\RouteFactory');
    }

    public function add($name, $config = array())
    {
        $this->routes[$name] = $this->factory->create($name, $config);
    }

    public function route(RequestInterface $request)
    {

    }

    public function generate($name, $params = array())
    {

    }

    public function __invoke($container)
    {
        $this->container = $container;
        if (isset($container['Packfire\\Router\\RouteFactoryInterface'])) {
            $this->factory = $container['Packfire\\Router\\RouteFactoryInterface'];
        } else {
            call_user_func($this->factory, $this->container);
        }
    }
}
