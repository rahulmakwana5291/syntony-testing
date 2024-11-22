<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/


use App\Http\Controllers\DynamoDbController;

Route::get('/', [DynamoDbController::class, 'getAllUserSettings']);
Route::get('/dynamodb/item', [DynamoDbController::class, 'getItem']);
Route::get('/dynamodb/query', [DynamoDbController::class, 'queryTable']);
