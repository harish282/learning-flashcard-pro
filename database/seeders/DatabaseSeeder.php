<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = $this->createUser('User 1');
        $user2 = $this->createUser('User 2');

        $deck1 = Deck::create(['user_id' => $user1->id, 'name' => 'Math Basics', 'is_public' => true]);
        $deck2 = Deck::create(['user_id' => $user2->id, 'name' => 'History', 'is_public' => false]);

        Card::create(['deck_id' => $deck1->id, 'question' => 'What is 2+2?', 'answer' => '4']);
        Card::create(['deck_id' => $deck1->id, 'question' => 'What is 3*3?', 'answer' => '9']);
        Card::create(['deck_id' => $deck2->id, 'question' => 'Who was Cleopatra?', 'answer' => 'Queen of Egypt']);

        $token = $user1->createToken('flashcardpro')->plainTextToken;
    }

    protected function createUser(string $name): User
    {
        $attributes = [
            'name' => $name,
            'email' => strtolower(str_replace(' ', '', $name)).'@am.test',
            'password' => Hash::make('password'),
        ];

        return User::factory()->create($attributes);
    }
}
