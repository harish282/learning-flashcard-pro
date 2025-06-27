<?php

namespace App\Livewire;

use App\Models\Deck;
use Livewire\Component;

class DeckShow extends Component
{
    public Deck $deck;

    public function mount(int $deckId)
    {
        $deck = Deck::findOrFail($deckId);
        $this->deck = $deck;
    }

    public function render()
    {
        $cards = $this->deck->cards;

        return view('livewire.deck-show', compact('cards'));
    }
}
