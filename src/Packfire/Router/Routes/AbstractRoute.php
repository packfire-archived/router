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

    /**
     * Create a new AbstractRoute object
     * @param string $name   The name of the route
     * @param array $config The configuration
     * @return void
     */
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

    /**
     * Assign an array of parameters to the route
     * @param array $params The array of parameters to set in the route
     * @return void
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Get the name of the route
     * @return string Returns the name of the route.
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the rules of the route
     * @return array Returns an array of rules configuration
     */
    public function rules()
    {
        return $this->rules;
    }
}
