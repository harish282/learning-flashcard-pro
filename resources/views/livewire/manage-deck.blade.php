<div class="px-3 py-6">
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start">
                <a class="btn btn-ghost btn-circle" wire:navigate href="{{ route('decks.index') }}">
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#cross"></use>
                    </svg>
                </a>
            </div>
            <div class="navbar-center">
                <a class="btn btn-ghost text-xl">{{ empty($deckId) ? __('Add Deck') : __('Edit Deck')}}</a>
            </div>
            <div class="navbar-end">

            </div>
        </div>
    </x-slot>
    <div class="grid gap-4">
        <div class="mb-4">
            <form wire:submit.prevent="saveDeck">
                <label class="label mb-2">Deck Name</label>
                <input wire:model="name" type="text" class="input {{  $errors->has('name') ? 'input-error' : '' }} w-full" autofocus/>

                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </form>
        </div>
    </div>
    <div class="fixed md:relative left-0 bottom-0 z-10 p-4 bg-white w-full">
        <div class="flex justify-between items-center">
            <a wire:navigate href="{{ route('decks.index') }}" class="btn btn-soft">Cancel</a>
            <button type="button" wire:key="save-deck-btn" wire:click="saveDeck" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>