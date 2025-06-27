<?php

namespace App\Livewire;

use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StudyDeck extends Component
{
    use AuthorizesRequests;

    public $deckId;

    public $cards = [];

    protected Deck $deck;

    public function mount($deckId)
    {
        $this->deckId = $deckId;
        $this->deck = Deck::findOrFail($deckId);
        $this->authorize('view', $this->deck);
        $this->cards = $this->deck->cards->shuffle()->toArray();
    }

    public function render()
    {
        return view('livewire.study-deck', [
            'deck' => $this->deck,
        ]);
    }
}
