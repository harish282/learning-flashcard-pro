<?php

namespace App\Livewire;

use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageDeck extends Component
{
    use AuthorizesRequests;

    public $name = '';

    public ?int $deckId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount(?int $deckId = null)
    {
        if ($deckId) {
            $this->deckId = $deckId;
            $deck = Deck::findOrFail($this->deckId);
            $this->authorize('update', $deck);
            $this->name = $deck->name;
        }
    }

    public function saveDeck()
    {
        try {
            if ($this->deckId) {
                return $this->editDeck();
            }

            return $this->createDeck();

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            $this->dispatch('flashcard-show-message', [
                'type' => 'error',
                'text' => 'Deck name must be unique. Please choose a different name.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('flashcard-show-message', [
                'type' => 'error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function createDeck()
    {
        $this->validate();
        Deck::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
        ]);
        $this->name = '';
        session()->flash('success', 'Deck created successfully.');

        return redirect()->route('decks.index');
    }

    public function editDeck()
    {
        $this->validate();

        $deck = Deck::findOrFail($this->deckId);
        $this->authorize('update', $deck);

        $deck->update(['name' => $this->name]);
        $this->name = '';

        session()->flash('success', 'Deck updated successfully.');

        return redirect()->route('decks.index');
    }

    public function render()
    {
        return view('livewire.manage-deck');
    }
}
