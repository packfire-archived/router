<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use Packfire\FuelBlade\ConsumerInterface;
use Packfire\Router\Dispatcher;

class RedirectRoute extends AbstractRoute implements ConsumerInterface
{
    protected $container;

    public function callback()
    {
        $target = $this->config['target'];
        $code = isset($this->config['http']) ? (int)$this->config['http'] : 302;

        header('Location: ' . $target, true, $code);
        exit;
    }

    public static function testConfig($config)
    {
        $result = false;
        if (isset($config['target'])) {
            $result = true;
        }
        return $result;
    }

    public function __invoke($container)
    {
        $this->container = $container;
    }
}
