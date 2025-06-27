<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\DeckShow;
use App\Livewire\DecksList;
use App\Livewire\ManageCard;
use App\Livewire\ManageDeck;
use App\Livewire\StudyDeck;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DecksList::class)->name('decks.index');
    Route::get('/decks/create', ManageDeck::class)->name('deck.create');
    Route::prefix('/decks/{deckId}')->group(function () {
        Route::get('/', DeckShow::class)->name('deck.show');
        Route::get('/edit', ManageDeck::class)->name('deck.edit');
        Route::get('/study', StudyDeck::class)->name('deck.study');
        Route::prefix('/cards')->group(function () {
            Route::get('/create', ManageCard::class)->name('card.create');
            Route::get('/{cardId}/edit', ManageCard::class)->name('card.edit');
        });
    });

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
});

require __DIR__.'/auth.php';
