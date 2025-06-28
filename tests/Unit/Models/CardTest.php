<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_has_correct_fillable_attributes(): void
    {
        $card = new Card();

        $this->assertSame(['deck_id', 'question', 'answer'], $card->getFillable());
    }

    #[Test]
    public function it_belongs_to_a_deck(): void
    {
        $deck = Deck::factory()->create();
        $card = Card::factory()->create(['deck_id' => $deck->id]);

        $this->assertInstanceOf(Deck::class, $card->deck);
        $this->assertSame($deck->id, $card->deck->id);
    }
}
