<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\FuelBlade\Container;
use Packfire\Config\ConfigFactory;

class Loader implements ConsumerInterface
{
    protected $container;

    protected $router;

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
        $this->container = new Container();
    }

    public function load()
    {
        if (isset($this->container['Packfire\\Router\\RouterInterface'])) {
            $this->router = $this->container['Packfire\\Router\\RouterInterface'];
        } else {
            $this->router = $this->container->instantiate('Packfire\\Router\\Router');
        }

        $factory = new ConfigFactory();
        $config = $factory->load($this->file);
        $routes = $config->get('routes');
        if ($routes) {
            foreach ($routes as $name => $config) {
                $this->router->add($name, $config);
            }
        }
        return $this->router;
    }

    public function __invoke($container)
    {
        $this->container = $container;
    }
}
