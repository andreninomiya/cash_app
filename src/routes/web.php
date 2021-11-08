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
$router->put('/user-types/{typeId}', 'UserTypesController@update');
$router->get('/user-types', 'UserTypesController@getAll');
$router->get('/user-types/{typeId}', 'UserTypesController@show');
$router->delete('/user-types/{typeId}', 'UserTypesController@delete');

$router->post('/users', 'UsersController@create');
$router->put('/users/{userId}', 'UsersController@update');
$router->get('/users', 'UsersController@getAll');
$router->get('/users/{userId}', 'UsersController@show');
$router->delete('/users/{userId}', 'UsersController@delete');

$router->post('/user-balances', 'UserBalancesController@create');
$router->put('/user-balances/{balanceId}', 'UserBalancesController@update');
$router->get('/user-balances', 'UserBalancesController@getAll');
$router->get('/user-balances/{balanceId}', 'UserBalancesController@show');
$router->delete('/user-balances/{balanceId}', 'UserBalancesController@delete');

$router->post('/transactions', 'TransactionsController@create');
$router->put('/transactions/{transactionId}', 'TransactionsController@update');
$router->get('/transactions', 'TransactionsController@getAll');
$router->get('/transactions/{transactionId}', 'TransactionsController@show');
$router->delete('/transactions/{transactionId}', 'TransactionsController@delete');
