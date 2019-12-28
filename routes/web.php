<?php

Route::get('/', function () {
    return view('practice');
});

Route::get('/search', function () {
    return view('search');
});


Route::get('/words/search', 'IndexController@searchWords');
Route::get('/word/find', 'IndexController@findWord');
Route::get('/word/random', 'IndexController@getRandomWord');

Route::post('/word/add', 'IndexController@addWord');
Route::post('/word/edit', 'IndexController@editWord');
Route::post('/translation/add', 'IndexController@addTranslation');
Route::post('/translation/remove', 'IndexController@removeTranslation');
