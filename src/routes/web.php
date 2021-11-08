<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', 'Controller@index');

$router->post('/user-types', 'UserTypesController@create');
$router->put('/user-types/{typeId}/{id}', 'UserTypesController@update');
$router->get('/user-types', 'UserTypesController@getAll');
$router->get('/user-types/{typeId}/{id}', 'UserTypesController@show');
$router->delete('/user-types/{typeId}/{id}', 'UserTypesController@delete');

$router->post('/users', 'UsersController@create');
$router->put('/users/{typeId}/{id}', 'UsersController@update');
$router->get('/users', 'UsersController@getAll');
$router->get('/users/{typeId}/{id}', 'UsersController@show');
$router->delete('/users/{typeId}/{id}', 'UsersController@delete');

$router->post('/user-balances', 'UserBalancesController@create');
$router->put('/user-balances/{typeId}/{id}', 'UserBalancesController@update');
$router->get('/user-balances', 'UserBalancesController@getAll');
$router->get('/user-balances/{typeId}/{id}', 'UserBalancesController@show');
$router->delete('/user-balances/{typeId}/{id}', 'UserBalancesController@delete');
$router->get('/user-balances/history/{typeId}/{id}', 'UserBalancesController@getHistory');

$router->post('/transactions', 'TransactionsController@create');
$router->put('/transactions/{typeId}/{id}', 'TransactionsController@update');
$router->get('/transactions', 'TransactionsController@getAll');
$router->get('/transactions/{typeId}/{id}', 'TransactionsController@show');
$router->delete('/transactions/{typeId}/{id}', 'TransactionsController@delete');
