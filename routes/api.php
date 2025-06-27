<?php

use App\Http\Controllers\Api\DeckController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'log.api'])->group(function () {
    Route::get('/decks', [DeckController::class, 'decks'])->name('api.decks.index');
    Route::get('/decks/{deck}/cards', [DeckController::class, 'cards'])->name('api.cards.index');
});
