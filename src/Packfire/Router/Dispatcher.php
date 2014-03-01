<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

class Dispatcher implements DispatcherInterface
{
    public function dispatch($action, $params = array())
    {
        $invokeParams = array();
        if (is_array($action)) {
            $reflection = new \ReflectionMethod($action[0], $action[1]);
            if ($reflection->isStatic()) {
                $invokeParams[] = null;
            } else {
                $invokeParams[] = $action[0];
            }
        } else {
            $reflection = new \ReflectionFunction($action);
        }

        $pass = array();
        foreach ($reflection->getParameters() as $param) {
            /* @var $param ReflectionParameter */
            if (isset($params[$param->getName()])) {
                $pass[] = $params[$param->getName()];
            } elseif ($param->isOptional()) {
                try {
                    $pass[] = $param->getDefaultValue();
                } catch (\ReflectionException $ex) {
                    // move on if there is no default value.
                }
            }
        }
        $invokeParams[] = $pass;

        return call_user_func_array(array($reflection, 'invokeArgs'), $invokeParams);
    }
}
