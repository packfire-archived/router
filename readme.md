#Packfire Router

[![Build Status](https://travis-ci.org/packfire/router.png?branch=master)](https://travis-ci.org/packfire/router)

Fast & clean URL router for PHP 5.3+.

- No-frills URL to callback routing
- Fast route dispatch through effective OOP design
- Scalable and expansive API

## Installing

Use [Composer](https://getcomposer.org/) to install `"packfire/router": "1.0.*"`.

1. Download `composer.phar`
2. Add `"packfire/router": "1.0.*"` under the `"require"` configuration in `composer.json`.
3. Run `php composer.phar install` to install Packfire Router. 

## Loading Routes from Config

Simply load your routes from any configuration format you like:

    $loader = new Loader('config/routes.yml'); // loading from a YAML file
    $loader = new Loader('config/routes.json'); // loading from a JSON file
    $loader = new Loader('config/routes.php'); // or loading from a PHP file that returns an array of configuration

	// create the router using the configuration
    $router = $loader->load();

A sample configuration looks like this (in YAML):

    routes:
      home:
        path: /
        method: get
        action: HeartCode\Blog\Controller::index
      post:
        path: /post/:id-:title
        method: get
        params:
          id: i
          title: slug
        action: HeartCode\Blog\Controller:view

##Routing Requests

Routing requests is simple:

    $loader = new Loader('config/routes.yml');
    $router = $loader->load();

 	// load data from $_SERVER
	$request = new CurrentRequest();

	// Get the route based on the current request
	$route = $router->route($request);

With the `$route` object in hand, you can easily execute the `$route` by simply running the callback:

	// performs the action that the route needs to
	$route->callback();