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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'status'], function () use ($router) {
    $router->get('/', 'StatusController@index');
    $router->get('/{id}', 'StatusController@show');
    $router->post('/', 'StatusController@store');
    $router->put('/{id}', 'StatusController@update');
    $router->delete('/{id}', 'StatusController@destroy');
});
$router->group(['prefix' => 'blocos'], function () use ($router) {
    $router->get('/', 'BlocosController@index');
    $router->get('/{id}', 'BlocosController@show');
    $router->post('/', 'BlocosController@store');
    $router->put('/{id}', 'BlocosController@update');
    $router->delete('/{id}', 'BlocosController@destroy');
});
$router->group(['prefix' => 'unidade'], function () use ($router) {
    $router->get('/', 'UnidadeController@index');
    $router->get('/{id}', 'UnidadeController@show');
    $router->post('/', 'UnidadeController@store');
    $router->put('/{id}', 'UnidadeController@update');
    $router->delete('/{id}', 'UnidadeController@destroy');
});
$router->group(['prefix' => 'empreendimentos'], function () use ($router) {
    $router->get('/', 'EmpreendimentosController@index');
    $router->get('/{id}', 'EmpreendimentosController@show');
    $router->post('/', 'EmpreendimentosController@store');
    $router->put('/{id}', 'EmpreendimentosController@update');
    $router->delete('/{id}', 'EmpreendimentosController@destroy');
});
