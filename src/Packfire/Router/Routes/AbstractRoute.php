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

    protected $rules;

    protected $config;

    public function __construct($name, $rules, $config)
    {
        $this->name = $name;
        $this->rules = $rules;
        $this->config = $config;
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
