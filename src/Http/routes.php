<?php

/**
 * Package Routes
 */

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers', 'prefix' => 'api'], function()
{
    Route::get('{model}/{id}', 'ApiController@show');
    Route::get('{model}', 'ApiController@index');
    Route::post('{model}', 'ApiController@index');
});

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers', 'prefix' => 'admin/crud'], function()
{
    Route::get('{model}/{id}', 'AdminController@show');
    Route::get('{model}', 'AdminController@index');
    Route::post('{model}', 'AdminController@index');
});
