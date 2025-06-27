<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ManageCard extends Component
{
    use AuthorizesRequests;

    public $question = '';

    public $answer = '';

    public int $deckId;

    public ?int $cardId = null;

    protected Deck $deck;

    protected $rules = [
        'question' => 'required|string|max:255',
        'answer' => 'required|string|max:255',
    ];

    public function mount(int $deckId, ?int $cardId = null)
    {
        $this->deckId = $deckId;
        $this->deck = Deck::findOrFail($this->deckId);
        $this->authorize('update', $this->deck);

        if ($cardId) {
            $this->cardId = $cardId;
            $card = $this->deck->cards()->findOrFail($this->cardId);
            $this->question = $card->question;
            $this->answer = $card->answer;
        }
    }

    public function saveCard()
    {
        $this->validate();

        try {
            $this->deck = Deck::findOrFail($this->deckId);
            $this->authorize('update', $this->deck);

            $card = Card::firstOrNew([
                'deck_id' => $this->deckId,
                'question' => $this->question,
            ]);

            $card->answer = $this->answer;
            $card->save();

            session()->flash('success', 'Card saved successfully.');

            return redirect()->route('deck.show', ['deckId' => $this->deckId]);

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            $this->dispatch('flashcard-show-message', [
                'type' => 'error',
                'text' => 'Question must be unique. Please choose a different question.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('flashcard-show-message', [
                'type' => 'error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.manage-card', ['deck' => $this->deck]);
    }
}
