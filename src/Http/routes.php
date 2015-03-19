<?php

/**
 * Package Routes
 */
// @codingStandardsIgnoreStart

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers'], function()
{
    Route::group(['prefix' => 'api'], function()
    {
        Route::get('{model}/{id}', 'ApiController@show');
        Route::get('{model}', 'ApiController@index');
        Route::post('{model}', 'ApiController@store');
    });

    Route::group(['prefix' => 'admin/crud'], function()
    {
        Route::get('{model}/{id}', 'AdminController@show');
        Route::get('{model}', 'AdminController@index');
        Route::post('{model}', 'AdminController@store');
    });
});

// @codingStandardsIgnoreEnd
