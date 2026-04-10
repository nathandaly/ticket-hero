<?php

use App\Http\Controllers\Board\IndexController as BoardIndexController;
use App\Http\Controllers\Board\UpdateStatusController as BoardUpdateStatusController;
use App\Http\Controllers\Leaderboard\IndexController as LeaderboardIndexController;
use App\Http\Controllers\Tickets\CreateController as TicketsCreateController;
use App\Http\Controllers\Tickets\StoreWebController as TicketsStoreWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/board')->name('home');

Route::get('/tickets/create', TicketsCreateController::class)->name('tickets.create');
Route::post('/tickets', TicketsStoreWebController::class)->name('tickets.store.web');
Route::get('/leaderboard', LeaderboardIndexController::class)->name('leaderboard.index');
Route::get('/board', BoardIndexController::class)->name('board.index');
Route::patch('/tickets/{ticket}/status', BoardUpdateStatusController::class)->name('tickets.update-status');
