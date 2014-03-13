<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\Router\Dispatcher;
use Packfire\FuelBlade\ContainerInterface;

class BaseRoute extends AbstractRoute implements ConsumerInterface
{
    /**
     * The FuelBlade IoC Container
     * @var Packfire\FuelBlade\ContainerInterface
     */
    protected $container;

    /**
     * Run the action of the route
     * @return void
     */
    public function execute()
    {
        if (isset($this->container['Packfire\\Router\\DispatcherInterface'])) {
            $dispatcher = $this->container['Packfire\\Router\\DispatcherInterface'];
        } else {
            $dispatcher = new Dispatcher();
        }

        if (isset($this->config['action'])) {
            $callback = self::loadCallback($this->container, $this->config['action']);
            $defaults = isset($this->config['defaults']) ? $this->config['defaults'] : array();
            $params = array_merge($defaults, $this->params);
            return $dispatcher->dispatch($callback, $params);
        }
    }

    /**
     * Test to ensure that the configuration can be used by this route
     * @param array $config The configuration to test for
     * @return boolean Returns true if the configuration can be used to create a BaseRoute, false otherwise.
     */
    public static function testConfig($config)
    {
        $result = false;
        if (isset($config['path']) && isset($config['action'])) {
            $result = true;
        }
        return $result;
    }

    /**
     * Preload the object in defined in the action
     * @param  Packfire\FuelBlade\ContainerInterface $container The FuelBlade IoC Container
     * @param  string|mixed $action The action string or object to load
     * @return array|callback Returns the array of callback
     */
    public static function loadCallback(ContainerInterface $container, $action)
    {
        if (is_string($action)) {
            $pos = strpos($action, '::');
            if ($pos !== false) {
                $action = array(
                    substr($action, 0, $pos),
                    substr($action, $pos + 2)
                );
                $action[0] = $container->instantiate($action[0]);
            }
        }
        return $action;
    }

    /**
     * Inject the object with the IoC container
     * @param  Packfire\FuelBlade\ContainerInterface|array $container The FuelBlade IoC Container
     * @return Packfire\Router\Routes\BaseRoute Returns self
     */
    public function __invoke($container)
    {
        $this->container = $container;
        return $this;
    }
}
