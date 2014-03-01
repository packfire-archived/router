<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\FuelBlade\Container;
use Packfire\Config\ConfigInterface;

class ConfigLoader implements LoaderInterface, ConsumerInterface
{
    protected $container;

    protected $router;

    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->container = new Container();
    }

    public function load(RouterInterface $router = null)
    {
        if (!$router) {
            if (isset($this->container['Packfire\\Router\\RouterInterface'])) {
                $router = $this->container['Packfire\\Router\\RouterInterface'];
            } else {
                $router = $this->container->instantiate('Packfire\\Router\\Router');
            }
        }

        $routes = $this->config->get('routes');
        if ($routes) {
            foreach ($routes as $name => $config) {
                $router->add($name, $config);
            }
        }
        return $router;
    }

    public function __invoke($container)
    {
        $this->container = $container;
    }
}
