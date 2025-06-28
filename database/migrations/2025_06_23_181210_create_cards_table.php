<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->text('answer');
            $table->timestamps();
            $table->unique(['deck_id', 'question'], 'unique_deck_question');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
