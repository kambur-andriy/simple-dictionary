<?php

Route::get('/', function () {
    return view('practice');
});

Route::get('/edit', function () {
    return view('edit');
});


Route::get('/find-word', 'IndexController@findWord');
Route::get('/get-random-word', 'IndexController@getRandomWord');
Route::get('/get-words', 'IndexController@getWords');

Route::post('/add-word', 'IndexController@addWord');
Route::post('/add-translation', 'IndexController@addTranslation');
Route::post('/remove-translation', 'IndexController@removeTranslation');
