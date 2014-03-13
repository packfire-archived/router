<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use Packfire\FuelBlade\ConsumerInterface;

class RedirectRoute extends AbstractRoute implements ConsumerInterface
{
    protected $container;

    /**
     * Run the action of the route
     * @return mixed Returns the result of the action
     */
    public function execute()
    {
        $target = $this->config['target'];
        $code = isset($this->config['http']) ? (int)$this->config['http'] : 302;

        header('Location: ' . $target, true, $code);
    }

    /**
     * Test to ensure that the configuration can be used by this route
     * @param array $config The configuration to test for
     * @return boolean Returns true if the configuration can be used to create a BaseRoute, false otherwise.
     */
    public static function testConfig($config)
    {
        $result = false;
        if (isset($config['target'])) {
            $result = true;
        }
        return $result;
    }

    /**
     * Inject the object with the IoC container
     * @param  Packfire\FuelBlade\ContainerInterface|array $container The FuelBlade IoC Container
     * @return Packfire\Router\Routes\RedirectRoute Returns self
     */
    public function __invoke($container)
    {
        $this->container = $container;
    }
}
