<?php

use App\Http\Controllers\Leaderboard\IndexController as LeaderboardIndexController;
use App\Http\Controllers\Tickets\StoreController as TicketsStoreController;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', TicketsStoreController::class)->name('api.tickets.store');
Route::get('/leaderboard', LeaderboardIndexController::class)->name('api.leaderboard.index');
