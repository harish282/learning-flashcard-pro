<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlashcardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_decks()
    {
        $response = $this->getJson('/api/decks');

        $response->assertUnauthorized();
    }

    public function test_unauthenticated_user_cannot_access_cards()
    {
        $user = User::factory()->create();
        $deck = Deck::create(['user_id' => $user->id, 'name' => 'Math', 'is_public' => true]);

        $response = $this->getJson('/api/decks/'.$deck->id.'/cards');

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_get_public_decks_with_token()
    {
        // Create a user
        $user = User::factory()->create();
        Deck::create(['user_id' => $user->id, 'name' => 'Math', 'is_public' => true]);
        Deck::create(['user_id' => $user->id, 'name' => 'Science', 'is_public' => true]);
        Deck::create(['user_id' => $user->id, 'name' => 'History', 'is_public' => false]);

        // Generate token and get plain text token
        $plainTextToken = $user->createToken('TestToken')->plainTextToken;

        // Make API request using token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$plainTextToken,
            'Accept' => 'application/json',
        ])->get('/api/decks');
        // Assert response status and structure
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                    ],
                ],
            ]);

        $response->assertJsonCount(2, 'data'); // Only public decks should be returned

    }

    public function test_authenticated_user_can_get_public_cards_with_token()
    {
        // Create a user
        $user = User::factory()->create();
        $deck = Deck::create(['user_id' => $user->id, 'name' => 'Math', 'is_public' => true]);
        Card::create(['deck_id' => $deck->id, 'question' => 'What is 2+2?', 'answer' => '4']);
        Card::create(['deck_id' => $deck->id, 'question' => 'What is 3*3?', 'answer' => '9']);

        // Generate token and get plain text token
        $plainTextToken = $user->createToken('TestToken')->plainTextToken;

        // Make API request using token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$plainTextToken,
            'Accept' => 'application/json',
        ])->get('/api/decks/'.$deck->id.'/cards');

        // Assert response status and structure
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'question',
                        'answer',
                        'deck_id',
                        'created_at',
                    ],
                ],
            ]);

    }
}
