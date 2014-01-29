<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\FuelBlade\ConsumerInterface;

class RouteFactory implements RouteFactoryInterface, ConsumerInterface
{
    protected $container;

    public function create($name, $config = array())
    {
        $types = array(
            'Packfire\\Router\\Routes\\BaseRoute',
            'Packfire\\Router\\Routes\\RedirectRoute'
        );
        foreach ($types as $type) {
            $result = call_user_func(array($type, 'testConfig'), $config);
            if ($result) {
                return $this->container->instantiate($type, array('name' => $name, 'config' => $config));
            }
        }
        return null;
    }

    public function __invoke($container)
    {
        $this->container = $container;
    }
}
