<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

class CurrentRequest implements RequestInterface
{
    protected $path;

    public function __construct($server = null)
    {
        if (!$server) {
            $server = $_SERVER;
        }
        $this->path = $this->determinePath($server);
    }

    protected function determinePath($server)
    {
        $path = null;
        if (isset($server['ORIG_PATH_INFO'])) {
            $path = $server['ORIG_PATH_INFO'];
        } elseif (isset($server['PATH_INFO'])) {
            $path = $server['PATH_INFO'];
        } else {
            $scriptName = $server['SCRIPT_NAME'];
            $phpSelf = $server['PHP_SELF'];
            if ($scriptName == $phpSelf) {
                $path = '/';
            } else {
                $path = substr($phpSelf, strlen($scriptName));
            }
        }
        return $path;
    }

    public function path()
    {
        return $this->path;
    }

    public function method()
    {

    }

    public function host()
    {

    }
}
