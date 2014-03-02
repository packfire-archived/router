<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\FuelBlade\Container;
use Packfire\Config\ConfigFactory;

class FileLoader implements LoaderInterface, ConsumerInterface
{
    /**
     * The IoC Container
     * @var Packfire\FuelBlade\ContainerInterface
     */
    protected $container;

    /**
     * The file to load from
     * @var string
     */
    protected $file;

    /**
     * Create a new FileLoader object
     * @param string $file The pathname to the file
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->container = new Container();
    }

    /**
     * Load the configuration to a router
     * @param  Packfire\Router\RouterInterface $router (optional) Provide a specific router to load the configuration into
     * @return Packfire\Router\RouterInterface Returns a router loaded with the configuration
     */
    public function load(RouterInterface $router = null)
    {
        if (!$router) {
            if (isset($this->container['Packfire\\Router\\RouterInterface'])) {
                $router = $this->container['Packfire\\Router\\RouterInterface'];
            } else {
                $router = $this->container->instantiate('Packfire\\Router\\Router');
            }
        }

        $factory = new ConfigFactory();
        $config = $factory->load($this->file);
        $routes = $config->get('routes');
        if ($routes) {
            foreach ($routes as $name => $route) {
                $router->add($name, $route);
            }
        }
        return $router;
    }

    /**
     * Inject the FuelBlade IoC Container
     * @param  Packfire\FuelBlade\ContainerInterface $container The container of dependencies to inject
     * @return Packfire\Router\FileLoader Returns self
     */
    public function __invoke($container)
    {
        $this->container = $container;
        return $this;
    }
}
