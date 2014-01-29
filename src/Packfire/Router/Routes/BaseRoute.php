<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\Router\Dispatcher;

class BaseRoute extends AbstractRoute implements ConsumerInterface
{
    protected $container;

    public function callback()
    {
        if (isset($this->container['Packfire\\Router\\DispatcherInterface'])) {
            $dispatcher = $this->container['Packfire\\Router\\DispatcherInterface'];
        } else {
            $dispatcher = new Dispatcher();
        }

        $params = array();
        if (isset($this->rules['path'])) {
            $params = $this->rules['path']->params();
        }
        if (isset($this->config['action'])) {
            $callback = self::loadCallback($this->config['action']);
            $dispatcher->dispatch($callback, $params);
        }
    }

    public static function testConfig($config)
    {
        $result = false;
        if (isset($config['path']) && isset($config['action'])) {
            $result = true;
        }
        return $result;
    }

    public static function loadCallback($action)
    {
        if (is_string($action)) {
            $pos = strpos($action, '::');
            if ($pos !== false) {
                $action = array(
                    substr($action, 0, $pos),
                    substr($action, $pos + 2)
                );
                $action[0] = $this->container->instantiate($action[0]);
            }
        }
        return $action;
    }

    public function __invoke($container)
    {
        $this->container = $container;
    }
}
