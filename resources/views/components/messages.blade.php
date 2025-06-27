<div class="toast toast-top toast-end z-20">
    @foreach(['message', 'success', 'error'] as $type)
        @if(session()->has($type))
            <div class="alert alert-{{ $type }}"
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
            >
                <span>{{ session($type) }}</span>
            </div>
        @endif
    @endforeach

    <div
        x-data="{ show: false, type: 'info', text: 'abcdd' }"
        @flashcard-show-message.window="
            type = $event.detail[0].type;
            text = $event.detail[0].text;
            show = true;
            setTimeout(() => show = false, 3000);
            console.log('Flashcard message event received:', $event.detail, type, text);
        "
        x-show="show"
        x-transition
        class="alert"
        :class="{
            'alert-success': type === 'success',
            'alert-error': type === 'error',
            'alert-warning': type === 'warning',
            'alert-info': type === 'info'
        }"
    >
        <span x-html="text"></span>
    </div>
</div>
