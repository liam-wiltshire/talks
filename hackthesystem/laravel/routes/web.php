<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/mysql', ['as' => 'mysql', 'uses' => 'IndexController@mysql']);
$router->get('/rce/{file}', ['as' => 'rce', 'uses' => 'IndexController@rce']);
$router->get('/image', ['as' => 'image', 'uses' => 'IndexController@image']);

