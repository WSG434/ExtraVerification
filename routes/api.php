<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', \App\Http\Controllers\UserController::class);

Route::post('sendEmailVerification/{id}', function(Request $request){
    //генерируем код и делаем запись в БД, что такой юзер и такой код в таблицу с кодами
    return 100100;
})->name('sendEmailVerification');

Route::post('checkEmailVerification', function(Request $request){
    //смотрим в БД все коды этого пользователя, проверяем срок действия, сортируем по дате и достаем самый первый
    $codeFromDB = 100100;
    $request->codeFromUser=100100;
    if ($codeFromDB===$request->codeFromUser){
        //меняем в БД значение и запускаем тем самым Событие и активируем Слушателей
        return response(true, 200);
    }
    return response(false, 401);
})->name('checkEmailVerification');

//Route::post('products/{product}/review', [ProductController::class, 'addReview'])
//    ->name('products.addReview');
