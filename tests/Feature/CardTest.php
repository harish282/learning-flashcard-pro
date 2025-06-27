<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Deck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_card()
    {
        $user = User::factory()->create();
        $deck = Deck::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('cards.store'), [
            'deck_id' => $deck->id,
            'question' => 'What is 2+2?',
            'answer' => '4',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('cards', [
            'deck_id' => $deck->id,
            'question' => 'What is 2+2?',
            'answer' => '4',
        ]);
    }
}
