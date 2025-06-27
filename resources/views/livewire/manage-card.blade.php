<div class="px-3 py-6">
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start">
                <a class="btn btn-ghost btn-circle" wire:navigate href="{{ route('deck.show', ['deckId' => $deckId]) }}">
                    <svg class="icon">
                        <use xlink:href="{{ asset('icons.svg') }}#cross"></use>
                    </svg>
                </a>
            </div>
            <div class="navbar-center">
                <a class="btn btn-ghost text-xl">{{ $deck->name }} :: {{ empty($cardId) ? __('Add Card') : __('Edit Card')}}</a>
            </div>
            <div class="navbar-end">

            </div>
        </div>
    </x-slot>
    <div class="grid gap-4">
        <div class="mb-4">
            <form wire:submit.prevent="saveCard">
                <div>
                    <label class="label mb-2">Question</label>
                    <input wire:model="question" type="text" class="input {{  $errors->has('question') ? 'input-error' : '' }} w-full" autofocus/>
                    @error('question') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label class="label mb-2">Answer</label>
                    <textarea wire:model="answer" type="text" class="textarea {{  $errors->has('answer') ? 'input-error' : '' }} w-full" rows="4"></textarea>
                    @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </form>
        </div>
    </div>
    <div class="fixed md:relative left-0 bottom-0 z-10 p-4 bg-white w-full">
        <div class="flex justify-between items-center">
            <a wire:navigate href="{{ route('deck.show', ['deckId' => $deckId]) }}" class="btn btn-soft">Cancel</a>
            <button type="button" wire:key="save-deck-btn" wire:click="saveCard" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>