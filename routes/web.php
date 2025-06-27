<?php

use App\Livewire\DeckShow;
use App\Livewire\DecksList;
use App\Livewire\ManageDeck;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DecksList::class)->name('decks.index');
    Route::get('/decks/create', ManageDeck::class)->name('deck.create');
    Route::prefix('/decks/{deckId}')->group(function () {
        Route::get('/', DeckShow::class)->name('deck.show');
        Route::get('/edit', ManageDeck::class)->name('deck.edit');
        Route::get('/study', ManageDeck::class)->name('deck.study');
        Route::get('/card', ManageDeck::class)->name('card.create');
    });
    Route::post('/cards', function () {
        // Placeholder for card creation route used in test
    })->name('cards.store');
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
