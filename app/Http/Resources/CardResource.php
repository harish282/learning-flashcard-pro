<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'deck_id' => $this->deck_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
