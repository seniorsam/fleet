<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1', 'middleware' => 'throttle:5,1'],function(){
    Route::get('/cars/expenses', 'ExpensesController@main');
});
