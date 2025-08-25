<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'web');

if (config('app.debug')) {
    Route::get('send-mail', [ContactController::class, 'sendMail']);
}
