<?php

Route::group(['namespace' => 'Taskforcedev\CrudAPI\Http\Controllers'], function () {
    Route::group(['middleware' => ['web'], 'prefix' => 'admin/'], function () {
        Route::post('create/{model}',   ['as' => 'crudapi.create.item', 'uses' => 'AdminController@store' ]);
        Route::patch('update/{model}',  ['as' => 'crudapi.update.item', 'uses' => 'AdminController@update']);
        Route::delete('delete/{model}', ['as' => 'crudapi.delete.item', 'uses' => 'AdminController@delete']);
        Route::get('{model}',           ['as' => 'crudapi.admin.model', 'uses' => 'AdminController@index' ]);
    });
});
