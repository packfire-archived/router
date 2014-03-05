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
    /**
     * The array of routes in the router
     * @var array
     */
    protected $routes = array();

    /**
     * The FuelBlade IoC container
     * @var Packfire\FuelBlade\ContainerInterface
     */
    protected $container;

    /**
     * The RouteFactory to use
     * @var Packfire\Router\RouteFactoryInterface
     */
    protected $factory;

    /**
     * Create a new Router object
     * @return void
     */
    public function __construct()
    {
        $this->container = new Container();
        $this->factory = $this->container->instantiate('Packfire\\Router\\RouteFactory');
    }

    /**
     * Add a new route to the router
     * @param string $name Name of the route to add into the router
     * @param array  $config The configuration of the route
     * @return void
     */
    public function add($name, $config = array())
    {
        $this->routes[$name] = $this->factory->create($name, $config);
    }

    /**
     * Route a request to its action
     * @param Packfire\Router\RequestInterface $request The request to route
     * @return Packfire\Router\RouteInterface Returns the matching route of the request
     */
    public function route(RequestInterface $request)
    {
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

    /**
     * Generate a URL for a route with its parameters
     * @param  string $name Name of the route in the router to generate
     * @param  array  $params (optional) The optional parameters to enter into the URL
     * @return string Returns the generated URL of the route and its parameters
     */
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

    /**
     * Inject the object with the IoC container
     * @param  Packfire\FuelBlade\ContainerInterface|array $container The FuelBlade IoC Container
     * @return Packfire\Router\Routes\BaseRoute Returns self
     */
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
