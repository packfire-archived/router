<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Matchers;

use Packfire\Router\RouteInterface;

class PathMatcher extends AbstractMatcher
{
    const TOKEN_REGEX = '`(\((.+)){0,1}:([\w\d_]+)(\?{0,1})\){0,1}`';

    public function match(RouteInterface $route)
    {
        $result = false;
        $rules = $route->rules();
        if (isset($rules['path'])) {
            $path = $rules['path'];
            if (isset($path['uri'])) {
                $uri = $path['uri'];
                $params = isset($path['params']) ? $path['params'] : array();

                $regex = self::regexCompiler($uri);
                $result = (bool)preg_match($regex, $this->request->path());
            }
        }
        return $result;
    }

    public static function regexCompiler($uri)
    {
        $matches = array();
        preg_match_all(self::TOKEN_REGEX, $uri, $matches, PREG_SET_ORDER);
        $regex = $uri;
        foreach ($matches as $match) {
            $quantifier = $match[4] == '?' ? '{0,1}' : '';
            $regex = str_replace($match[0], '(?<' . $match[3] . '>' . preg_quote($match[2], '`') . '(.+))' . $quantifier, $regex);
        }
        return '`^' . $regex . '$`';
    }
}
