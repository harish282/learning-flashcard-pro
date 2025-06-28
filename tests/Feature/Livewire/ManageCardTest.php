<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ManageCard;
use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_card_in_their_deck()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->set('question', 'What is Laravel?')
            ->set('answer', 'A PHP framework')
            ->call('saveCard')
            ->assertRedirect(route('deck.show', ['deckId' => $deck->id]));

        $this->assertDatabaseHas('cards', [
            'deck_id' => $deck->id,
            'question' => 'What is Laravel?',
            'answer' => 'A PHP framework',
        ]);
    }

    public function test_validation_fails_if_fields_are_empty()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->set('question', '')
            ->set('answer', '')
            ->call('saveCard')
            ->assertHasErrors(['question' => 'required', 'answer' => 'required']);
    }

    public function test_user_can_edit_existing_card()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->for($user)->create();

        $card = Card::factory()->for($deck)->create([
            'question' => 'Old Question',
            'answer' => 'Old Answer',
        ]);

        Livewire::actingAs($user)
            ->test(ManageCard::class, [
                'deckId' => $deck->id,
                'cardId' => $card->id,
            ])
            ->assertSet('question', 'Old Question')
            ->assertSet('answer', 'Old Answer')
            ->set('answer', 'Updated Answer')
            ->call('saveCard')
            ->assertRedirect(route('deck.show', ['deckId' => $deck->id]));

        $this->assertDatabaseHas('cards', [
            'id' => $card->id,
            'question' => 'Old Question',
            'answer' => 'Updated Answer',
        ]);
    }

    public function test_user_cannot_manage_card_in_others_deck()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $deck = Deck::factory()->for($otherUser)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->assertForbidden();
    }
}
