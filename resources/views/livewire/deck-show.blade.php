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
    @if(!$cards->isEmpty())
        <h2>{{ __('Cards') }}</h2>
    @endif
    <div  class="mt-4 grid gap-4">
        @foreach($cards as $card)
        <ul class="list bg-base-100 rounded-box shadow-md">
            <li class="list-row" wire:key="card-{{ $card->id }}">
                <div class="text-xl font-thin opacity-30 tabular-nums">{{$loop->index+1}}</div>
                <div class="list-col-grow">
                    <div class="font-bold">
                        {{ $card->question }}
                    </div>
                    <div class="text-md">
                        {{ $card->answer }}
                    </div>
                </div>
                <button class="btn btn-square btn-ghost"
                    wire:click.stop="deleteCard({{ $card->id }})"
                    wire:confirm="Are you sure you want to delete this card?"
                    wire:key="delete-card-{{ $card->id }}"
                >
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#trash"></use>
                    </svg>
                </button>
                <button class="btn btn-square btn-ghost"
                    wire:click.stop="editCard({{ $card->id }})"
                    wire:key="edit-card-{{ $card->id }}"
                >
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#pencil"></use>
                    </svg>
                </button>
            </li>
        </ul>
        @endforeach
    </div>
</div>