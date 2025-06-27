<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Http\Resources\CardResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CardController extends Controller
{
    use AuthorizesRequests;

    public function index(Deck $deck)
    {
        $this->authorize('view', $deck);
        return CardResource::collection($deck->cards);
    }
}
