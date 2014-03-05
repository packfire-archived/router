<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Router project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Router\Exceptions;

class InvalidParameterException extends \Exception
{
    public function __construct($parameter)
    {
        parent::__construct('The parameter "' . $parameter . '" does not match the required rule.');
    }
}
