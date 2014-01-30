<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

use Packfire\Router\Matchers\PathMatcher;

class Generator implements GeneratorInterface
{
    public function generate(RouteInterface $route, $params)
    {
        $rules = $route->rules();
        if (isset($rules['path'])) {
            $path = $rules['path'];
            if (isset($path['uri'])) {
                $uri = $path['uri'];
                $paramRules = isset($path['params']) ? $path['params'] : array();

                $tokens = PathMatcher::createTokens($uri);

                if ($tokens) {
                    $replacements = array();
                    foreach ($tokens as $token) {
                        $name = $token[3];
                        if (isset($params[$name])) {
                            $replacements[$token[1]] = $params[$name];
                        }
                    }
                    $uri = str_replace(array_keys($replacements), $replacements, $uri);
                }
                return $uri;
            }
        }
    }
}
