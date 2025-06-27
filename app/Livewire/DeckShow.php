<?php

namespace App\Livewire;

use App\Models\Deck;
use Livewire\Component;

class DeckShow extends Component
{
    public $deckId;

    protected Deck $deck;

    public function mount(int $deckId)
    {
        $this->deckId = $deckId;
        $deck = Deck::findOrFail($deckId);
        $this->deck = $deck;
    }

    public function editCard(int $cardId)
    {
        return redirect()->route('card.edit', ['deckId' => $this->deckId, 'cardId' => $cardId]);
    }

    public function deleteCard($cardId)
    {
        $this->deck = Deck::findOrFail($this->deckId);
        $this->authorize('delete', $this->deck);

        $card = $this->deck->cards()->findOrFail($cardId);
        $card->delete();
        session()->flash('message', 'Card deleted successfully.');
    }

    public function render()
    {
        $cards = $this->deck->cards()->orderBy('created_at', 'asc')->get();

        return view('livewire.deck-show', ['cards' => $cards, 'deck' => $this->deck]);
    }
}
