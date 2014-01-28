<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use Packfire\Router\RouteInterface;

class MethodMatcher extends AbstractMatcher
{
    public function match(RouteInterface $route)
    {
        $result = true;
        $rules = $route->rules();
        if (isset($rules['method'])) {
            $methods = (array)$rules['method'];
            foreach ($methods as $method) {
                $result = (strtolower($method) == strtolower($this->request->method()));
                if ($result) {
                    break;
                }
            }
        }
        return $result;
    }
}
