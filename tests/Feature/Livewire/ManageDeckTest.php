<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ManageDeck;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageDeckTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_component()
    {
        $this->get(route('decks.index'))
            ->assertRedirect('/login');
    }

    public function test_user_can_create_deck()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageDeck::class)
            ->set('name', 'My Deck')
            ->set('is_public', true)
            ->call('saveDeck')
            ->assertRedirect(route('decks.index'));

        $this->assertDatabaseHas('decks', [
            'name' => 'My Deck',
            'user_id' => $user->id,
            'is_public' => true,
        ]);
    }

    public function test_name_is_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageDeck::class)
            ->set('name', '')
            ->call('saveDeck')
            ->assertHasErrors(['name' => 'required']);
    }

    public function test_user_can_edit_own_deck()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->create([
            'user_id' => $user->id,
            'name' => 'Old Name',
            'is_public' => false,
        ]);

        Livewire::actingAs($user)
            ->test(ManageDeck::class, ['deckId' => $deck->id])
            ->assertSet('name', 'Old Name')
            ->assertSet('is_public', false)
            ->set('name', 'Updated Name')
            ->set('is_public', true)
            ->call('saveDeck')
            ->assertRedirect(route('decks.index'));

        $this->assertDatabaseHas('decks', [
            'id' => $deck->id,
            'name' => 'Updated Name',
            'is_public' => true,
        ]);
    }

    public function test_user_cannot_edit_others_deck()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $deck = Deck::factory()->create(['user_id' => $otherUser->id]);

        Livewire::actingAs($user)
            ->test(ManageDeck::class, ['deckId' => $deck->id])
            ->assertForbidden();
    }
}
