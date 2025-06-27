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

    public $is_public = true;

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
            $this->is_public = $deck->is_public;
        }
    }

    public function saveDeck()
    {
        $this->validate();
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

    protected function createDeck()
    {
        Deck::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'is_public' => $this->is_public,
        ]);
        $this->reset();

        session()->flash('success', 'Deck created successfully.');

        return redirect()->route('decks.index');
    }

    protected function editDeck()
    {
        $deck = Deck::findOrFail($this->deckId);
        $this->authorize('update', $deck);

        $deck->update(['name' => $this->name, 'is_public' => $this->is_public]);
        $this->reset();

        session()->flash('success', 'Deck updated successfully.');

        return redirect()->route('decks.index');
    }

    public function render()
    {
        return view('livewire.manage-deck');
    }
}
