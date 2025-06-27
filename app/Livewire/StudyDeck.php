<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deck;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StudyDeck extends Component
{
    use AuthorizesRequests;

    public $deckId;
    public $cards = [];
    public $currentCardIndex = 0;
    public $showAnswer = false;

    public function mount($deckId)
    {
        $this->deckId = $deckId;
        $deck = Deck::findOrFail($deckId);
        $this->authorize('view', $deck);
        $this->cards = $deck->cards->shuffle()->toArray();
    }

    public function toggleAnswer()
    {
        $this->showAnswer = !$this->showAnswer;
    }

    public function nextCard()
    {
        $this->showAnswer = false;
        $this->currentCardIndex = ($this->currentCardIndex + 1) % count($this->cards);
    }

    public function render()
    {
        return view('livewire.study-deck', [
            'currentCard' => $this->cards[$this->currentCardIndex] ?? null,
            'showAnswer' => $this->showAnswer,
        ]);
    }
}
