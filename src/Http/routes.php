<?php

/**
 * Package Routes
 */

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers', 'prefix' => 'crud'], function()
{
    Route::get('{model}/{id}', 'ApiController@show');
    Route::get('{model}', 'ApiController@index');
    Route::post('{model}', 'ApiController@index');
});
