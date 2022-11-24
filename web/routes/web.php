<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;

Route::get('/', fn () => redirect('/threads'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('threads', ThreadController::class);
    Route::post('threads/{thread}/replies', [ReplyController::class, 'store'])
        ->middleware('analyse.text')
        ->name('replies.store');
});
