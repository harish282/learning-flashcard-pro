<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold mb-4">Study Deck</h2>
    @if($currentCard)
    <div class="border p-4 rounded text-center">
        <h3 class="text-xl mb-4">{{ $currentCard['question'] }}</h3>
        @if($showAnswer)
        <p class="text-lg mb-4">{{ $currentCard['answer'] }}</p>
        @endif
        <button wire:click="toggleAnswer" class="bg-blue-500 text-white p-2 rounded mr-2">
            {{ $showAnswer ? 'Hide Answer' : 'Show Answer' }}
        </button>
        <button wire:click="nextCard" class="bg-green-500 text-white p-2 rounded">Next Card</button>
    </div>
    @else
    <p>No cards available in this deck.</p>
    @endif
</div>