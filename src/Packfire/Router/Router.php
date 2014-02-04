<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\FuelBlade\Container;
use Packfire\Router\Exceptions\RouteNotFoundException;

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
        $matchers = array();
        if (isset($this->container['Packfire\\Router\\MatcherInterface'])) {
            $matchers = (array)$this->container['Packfire\\Router\\MatcherInterface'];
        } else {
            $matchers = array(
                'Packfire\\Router\\Matchers\\HostMatcher',
                'Packfire\\Router\\Matchers\\MethodMatcher',
                'Packfire\\Router\\Matchers\\PathMatcher'
            );
        }

        foreach ($matchers as $i => $matcher) {
            $matchers[$i] = new $matcher($request);
        }

        foreach ($this->routes as $route) {
            $result = true;
            foreach ($matchers as $matcher) {
                $result = $matcher->match($route);
                if (!$result) {
                    break;
                }
            }
            if ($result) {
                return $route;
            }
        }
        return null;
    }

    public function generate($name, $params = array())
    {
        if (isset($this->routes[$name])) {
            if (isset($this->container['Packfire\\Router\\GeneratorInterface'])) {
                $generator = $this->container['Packfire\\Router\\GeneratorInterface'];
            } else {
                $generator = new Generator();
            }
            return $generator->generate($this->routes[$name], $params);
        } else {
            throw new RouteNotFoundException($name);
        }
    }

    public function __invoke($container)
    {
        $this->container = $container;
        if (isset($container['Packfire\\Router\\RouteFactoryInterface'])) {
            $this->factory = $container['Packfire\\Router\\RouteFactoryInterface'];
        } else {
            call_user_func($this->factory, $this->container);
        }
        return $this;
    }
}
