<?php

use Illuminate\Support\Facades\Route;
use TealOrca\LaravelFreshchat\Http\Controllers\FreshchatController;

Route::group(['middleware' => ['web']], function () {

    Route::post('lfcstorechatuser', [FreshchatController::class, 'storeFreshchatUserId'])
        ->name('user.storeFreshchatUserId');

});
