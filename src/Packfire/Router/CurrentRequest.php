<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router;

class CurrentRequest implements RequestInterface
{
    /**
     * The path of the current request
     * @var string
     */
    protected $path;

    /**
     * The HTTP method of the current request
     * @var string
     */
    protected $method;

    /**
     * The Host requested to
     * @var string
     */
    protected $host;

    /**
     * Create a new CurrentRequest object
     * @param array $server (optional) The $_SERVER information to build the request.
     */
    public function __construct($server = null)
    {
        if (!$server) {
            $server = $_SERVER;
        }
        $this->path = $this->determinePath($server);
        if (isset($server['REQUEST_METHOD'])) {
            $this->method = $server['REQUEST_METHOD'];
        }
        if (isset($server['HTTP_HOST'])) {
            $this->host = $server['HTTP_HOST'];
        }
    }

    protected function determinePath($server)
    {
        if (isset($server['ORIG_PATH_INFO'])) {
            $path = $server['ORIG_PATH_INFO'];
        } elseif (isset($server['PATH_INFO'])) {
            $path = $server['PATH_INFO'];
        } else {
            $scriptName = isset($server['SCRIPT_NAME']) ? $server['SCRIPT_NAME'] : '';
            $phpSelf = isset($server['PHP_SELF']) ? $server['PHP_SELF'] : '';
            if ($scriptName == $phpSelf) {
                $path = '/';
            } else {
                $path = substr($phpSelf, strlen($scriptName));
            }
        }
        return $path;
    }

    /**
     * Get the path of the current request
     * @return string Returns the string containing the path of the current request.
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Get the method of the current request
     * @return string Returns the string containing the method of the current request.
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Get the host of the current request
     * @return string Returns the string containing the host of the current request.
     */
    public function host()
    {
        return $this->host;
    }
}
