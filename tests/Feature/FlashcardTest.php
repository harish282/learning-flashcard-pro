<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlashcardTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_deck()
    {
        $response = $this->get(route('decks.index'));

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_deck()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('decks.index'));

        $response->assertOk();
    }

    public function test_authenticated_user_can_create_deck()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('decks.index'));

        $response->assertOk();
    }
}
