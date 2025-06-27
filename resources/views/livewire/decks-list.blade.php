<div class="px-3 py-6">
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start"></div>
            <div class="navbar-center">
                <a class="btn btn-ghost text-xl">My Decks</a>
            </div>
            <div class="navbar-end">
                <a class="btn btn-ghost btn-circle" wire:navigate href="{{ route('deck.create') }}">
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#plus"></use>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>
    <div class="grid gap-4">
        @foreach($decks as $deck)
        <ul class="list bg-base-100 rounded-box shadow-md">
            <li class="list-row" wire:click="showDeck({{ $deck->id }})" wire:key="deck-{{ $deck->id }}">
                <div class="text-4xl font-thin opacity-30 tabular-nums">{{$loop->index+1}}</div>
                <div class="list-col-grow">
                    <div class="font-bold">{{ $deck->name }}</div>
                    <div class="text-xs uppercase font-semibold opacity-60">{{ $deck->cards_count }} cards</div>
                </div>
                <button class="btn btn-square btn-ghost"
                    wire:click.stop="deleteDeck({{ $deck->id }})"
                    wire:confirm="Are you sure you want to delete this deck?"
                    wire:key="delete-deck-{{ $deck->id }}"
                >
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#trash"></use>
                    </svg>
                </button>
                <button class="btn btn-square btn-ghost"
                    wire:click.stop="editDeck({{ $deck->id }})"
                    wire:key="edit-deck-{{ $deck->id }}"
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