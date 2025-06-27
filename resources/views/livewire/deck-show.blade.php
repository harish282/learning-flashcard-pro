<x-slot name="header">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <a class="btn btn-ghost btn-circle" href="{{ route('decks.index') }}" wire:navigate>
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
            </a>
        </div>
        <div class="navbar-center">
            <a class="btn btn-ghost text-xl">{{ $deck->name }}</a>
        </div>
        <div class="navbar-end"></div>
    </div>
</x-slot>
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        @if($cards->isEmpty())
            <p class="text-gray-500">Add your first card.</p>
        @else
            <a href="{{ route('deck.study', ['deckId' => $deck->id]) }}" class="btn btn-primary">Study This Deck</a>
        @endif
        <a wire:navigate href="{{ route('card.create', ['deckId' => $deck->id]) }}" class="btn btn-soft">+ Add New Card</a>
    </div>
    <div class="mt-4">
        @foreach($cards as $card)
        <div class="p-4 bg-gray-100 rounded shadow mb-2">
            <p><strong>Question:</strong> {{ $card->question }}</p>
            <p><strong>Answer:</strong> {{ $card->answer }}</p>
        </div>
        @endforeach
    </div>
</div>