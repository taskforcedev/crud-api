<?php

/**
 * Package Routes
 */

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers', 'prefix' => 'crud'], function()
{
    Route::get('get/{id}', 'ApiController@show')
    Route::get('get', 'ApiController@index')
    Route::post('get', 'ApiController@index')
});