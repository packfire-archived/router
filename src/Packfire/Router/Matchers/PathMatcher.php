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
                $paramRules = isset($path['params']) ? $path['params'] : array();

                $tokens = self::createTokens($uri);
                $regex = self::regexCompiler($uri, $tokens);
                $uriParams = array();
                $result = (bool)preg_match($regex, $this->request->path(), $uriParams);
            }
        }
        return $result;
    }

    public static function validate($params, $name, $rule)
    {
        $result = true;
        if (isset($params[$name])) {
            switch ($rule) {
                case 'i':
                case 'int':
                case 'integer':
                case 'number':
                case 'numbers':
                    $rule = '^[0-9]+$';
                    break;
                case 'a':
                case 'alpha':
                case 'alphabet':
                case 'alphabets':
                    $rule = '^[a-zA-Z]+$';
                    break;
                case 'an':
                case 'alnum':
                case 'alphanumeric':
                    $rule = '^[a-zA-Z0-9]+$';
                    break;
                case 'slug':
                    $rule = '^[a-zA-Z0-9-]+$';
                    break;
                case 'hex':
                    $rule = '^[a-fA-F0-9]+$';
                    break;
                default:
                    if (substr($rule, 0, 1) != '^' && substr($rule, -1) != '$') {
                        $rule = '^' . $rule . '$';
                    }
                    break;
            }
            $result = (bool)preg_match('`' . $rule . '`', $params[$name]);
        }
        return $result;
    }

    public static function createTokens($uri)
    {
        $matches = array();
        preg_match_all(self::TOKEN_REGEX, $uri, $matches, PREG_SET_ORDER);
        return $matches;
    }

    public static function regexCompiler($uri, $tokens)
    {
        $changes = array();
        foreach ($tokens as $token) {
            $quantifier = $token[4] == '?' ? '{0,1}' : '';
            $changes[$token[0]] = preg_quote($token[2], '`') . '(?<' . $token[3] . '>' . '(.+))' . $quantifier;
        }
        return '`^' . str_replace(array_keys($changes), $changes, $uri) . '$`';
    }
}
