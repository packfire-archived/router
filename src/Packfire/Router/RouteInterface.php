<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

interface RouteInterface
{
    /**
     * @return void
     */
    public function __construct($name, $config);

    public static function testConfig($config);

    /**
     * @return string
     */
    public function name();

    /**
     * @return array
     */
    public function rules();

    /**
     * @return void
     */
    public function callback();

    /**
     * @return void
     */
    public function setParams($params);
}
