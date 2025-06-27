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

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_create_card_in_own_deck()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->set('question', 'What is Laravel?')
            ->set('answer', 'A PHP framework')
            ->call('saveCard')
            ->assertRedirect(route('deck.show', ['deck' => $deck->id]));

        $this->assertDatabaseHas('cards', [
            'deck_id' => $deck->id,
            'question' => 'What is Laravel?',
            'answer' => 'A PHP framework',
        ]);
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function test_validation_fails_for_invalid_input($question, $answer, $expectedErrors)
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->set('question', $question)
            ->set('answer', $answer)
            ->call('saveCard')
            ->assertHasErrors($expectedErrors);

        $this->assertDatabaseMissing('cards', ['deck_id' => $deck->id]);
    }

    public function validationDataProvider()
    {
        return [
            'empty fields' => [
                'question' => '',
                'answer' => '',
                'errors' => ['question' => 'required', 'answer' => 'required'],
            ],
            'question too long' => [
                'question' => str_repeat('a', 256),
                'answer' => 'Valid answer',
                'errors' => ['question' => 'max'],
            ],
        ];
    }

    public function test_can_edit_existing_card()
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
            ->set('question', 'Updated Question')
            ->set('answer', 'Updated Answer')
            ->call('saveCard')
            ->assertRedirect(route('deck.show', ['deck' => $deck->id]));

        $this->assertDatabaseHas('cards', [
            'id' => $card->id,
            'question' => 'Updated Question',
            'answer' => 'Updated Answer',
        ]);
    }

    public function test_cannot_manage_card_in_others_deck()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $deck = Deck::factory()->for($otherUser)->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => $deck->id])
            ->assertForbidden();
    }

    public function test_fails_if_deck_does_not_exist()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageCard::class, ['deckId' => 999])
            ->assertStatus(404);
    }
}
