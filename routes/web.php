<?php

use App\Http\Controllers\DiscordTest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('welcome');
});

Route::get('/test', [DiscordTest::class, 'index']);
Route::get('/send-message-to-discord', [DiscordTest::class, 'sendMessageToDiscord']);
