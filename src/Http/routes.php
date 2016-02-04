<?php

/**
 * Package Routes
 */

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers'], function () {

    Route::group(['middleware' => 'web', 'prefix' => 'api'], function () {
        Route::get('{model}/{id}',    [ 'as' => 'crudapi.show',    'uses' => 'ApiController@show'    ]);
        Route::get('{model}',         [ 'as' => 'crudapi.index',   'uses' => 'ApiController@index'   ]);
        Route::post('{model}',        [ 'as' => 'crudapi.store',   'uses' => 'ApiController@store'   ]);
        Route::delete('{model}/{id}', [ 'as' => 'crudapi.destroy', 'uses' => 'ApiController@destroy' ]);
        Route::patch('{model}/{id}',  [ 'as' => 'crudapi.update',  'uses' => 'ApiController@update'  ]);
    });

    Route::group(['middleware' => ['web'], 'prefix' => 'admin/crud'], function () {
        Route::get('{model}/{id}', 'AdminController@show');
        Route::get('{model}', [ 'as' => 'crudapi.admin.model', 'uses' => 'AdminController@index' ]);
    });

});
