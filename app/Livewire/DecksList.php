<?php

namespace App\Livewire;

use App\Models\Deck;
use Livewire\Component;

class DecksList extends Component
{
    public function showDeck($deckId)
    {
        return redirect()->route('deck.show', ['deckId' => $deckId]);
    }

    public function editDeck($deckId)
    {
        return redirect()->route('deck.edit', ['deckId' => $deckId]);
    }

    public function deleteDeck($deckId)
    {
        $deck = Deck::findOrFail($deckId);
        $this->authorize('delete', $deck);
        $deck->delete();
        session()->flash('message', 'Deck deleted successfully.');
    }

    public function render()
    {
        $decks = Deck::withCount('cards')->where('user_id', auth()->id())->get();

        return view('livewire.decks-list', compact('decks'));
    }
}
