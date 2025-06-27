<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\DeckResource;
use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeckController extends Controller
{
    use AuthorizesRequests;

    public function decks()
    {
        $decks = Deck::where('is_public', true)->get();

        return DeckResource::collection($decks);
    }

    public function cards(Deck $deck)
    {
        $this->authorize('view', $deck);

        return CardResource::collection($deck->cards);
    }
}
