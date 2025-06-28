<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageCard extends Component
{
    use AuthorizesRequests;

    public $question = '';

    public $answer = '';

    public int $deckId;

    public ?int $cardId = null;

    protected ?Deck $deck = null;

    protected function rules()
    {
        return [
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cards', 'question')->where('deck_id', $this->deckId)->ignore($this->cardId),
            ],
            'answer' => 'required|string|max:255',
        ];
    }

    public function mount(int $deckId, ?int $cardId = null)
    {
        $this->deckId = $deckId;
        $this->deck = Deck::findOrFail($deckId);
        $this->authorize('update', $this->deck);

        if ($cardId) {
            $this->cardId = $cardId;
            $card = $this->deck->cards()->findOrFail($this->cardId);
            $this->question = $card->question;
            $this->answer = $card->answer;
        }
    }

    public function boot()
    {
        if ($this->deckId && ! $this->deck) {
            $this->deck = Deck::findOrFail($this->deckId);
            $this->authorize('view', $this->deck);
        }
    }

    public function saveCard()
    {
        $this->deck = Deck::findOrFail($this->deckId);
        $this->validate();

        try {
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
