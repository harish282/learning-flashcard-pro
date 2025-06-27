
<div class="dock md:hidden">
  <a  wire:navigate href="{{ route('decks.index') }}">
    <svg class="icon">
        <use xlink:href="{{ asset('icons.svg') }}#home"></use>
    </svg>
    <span class="dock-label">Decks</span>
  </a>

  <a  wire:navigate href="{{ route('deck.create') }}">
    <svg class="icon">
        <use xlink:href="{{ asset('icons.svg') }}#plus"></use>
    </svg>
    <span class="dock-label">Create</span>
  </a>

  <a  wire:navigate href="{{ route('profile') }}">
    <svg class="icon">
        <use xlink:href="{{ asset('icons.svg') }}#user"></use>
    </svg>
    <span class="dock-label">Profile</span>
  </a>
</div>
