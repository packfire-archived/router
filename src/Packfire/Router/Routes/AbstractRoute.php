<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Routes;

use Packfire\Router\RouteInterface;

abstract class AbstractRoute implements RouteInterface
{
    protected $name;

    protected $rules = array();

    protected $config;

    protected $params = array();

    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->config = $config;

        $this->rules['host'] = isset($config['host']) ? $config['host'] : array();
        $this->rules['method'] = isset($config['method']) ? $config['method'] : array();
        if (isset($config['path'])) {
            $this->rules['path'] = array(
                'uri' => $config['path'],
                'params' => isset($config['params']) ? $config['params'] : array()
            );
        }
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function name()
    {
        return $this->name;
    }

    public function rules()
    {
        return $this->rules;
    }
}
