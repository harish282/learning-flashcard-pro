<?php

namespace Tests\Unit\Models;

use App\Models\Deck;
use App\Models\User;
use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeckTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_has_correct_fillable_attributes(): void
    {
        $deck = new Deck();

        $this->assertSame(['name', 'user_id', 'is_public'], $deck->getFillable());
    }

    #[Test]
    public function it_belongs_to_a_user(): void
    {
        $deck = Deck::factory()->create();

        $this->assertInstanceOf(User::class, $deck->user);
    }

    #[Test]
    public function it_has_many_cards(): void
    {
        $deck = Deck::factory()->create();
        $cards = Card::factory()->count(3)->create(['deck_id' => $deck->id]);

        $this->assertCount(3, $deck->cards);
        $this->assertInstanceOf(Card::class, $deck->cards->first());
    }
}
