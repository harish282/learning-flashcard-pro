<x-slot name="header">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <a class="btn btn-ghost btn-circle" href="{{ route('deck.show', ['deckId' => $deck->id]) }}" wire:navigate>
                <svg class="icon">
                    <use xlink:href="{{ asset('icons.svg') }}#go-back"></use>
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
    @if(!empty($cards))
    <div class="border p-4 bg-white rounded text-center">
        <!-- Vue.js Component Here -->
        <div id="vue-app"
            x-data
            x-init="$nextTick(() => window.initVueApp(@js($cards)))"
            wire:ignore
        >
            <!-- Vue app mounts here -->
        </div>
    </div>
    @else
    <p>No cards available in this deck.</p>
    @endif
</div>
@push('js')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
    window.initVueApp = function(cards) {
        const { createApp, ref, computed } = Vue;

        createApp({
            setup() {
                const currentIndex = ref(0);
                const showAnswer = ref(false);
                const finished = ref(false);
                const responses = ref([]);
                const total = cards.length;

                const currentCard = computed(() => cards[currentIndex.value]);
                const progress = computed(() => ((currentIndex.value + 1) / total) * 100);

                const correctCount = computed(() =>
                    responses.value.filter(r => r.correct).length
                );

                const wrongCount = computed(() =>
                    responses.value.filter(r => !r.correct).length
                );

                function reveal() {
                    showAnswer.value = true;
                }

                function answer(correct) {
                    responses.value.push({
                        index: currentIndex.value,
                        correct,
                        question: currentCard.value.question,
                        answer: currentCard.value.answer
                    });

                    showAnswer.value = false;
                    if (currentIndex.value + 1 < total) {
                        currentIndex.value++;
                    } else {
                        finished.value = true;
                        // Send results back to Livewire
                        Livewire.dispatch('receiveResults', responses.value);
                    }
                }

                return {
                    currentCard,
                    currentIndex,
                    total,
                    showAnswer,
                    reveal,
                    answer,
                    progress,
                    finished,
                    correctCount,
                    wrongCount
                };
            },
            template: `
            <div>
                <div v-if="!finished && currentCard" class="space-y-4 ">
                    <div class="text-lg font-bold">
                        Card @{{ currentIndex + 1 }} of @{{ total }}
                    </div>
                    <div class="w-full bg-gray-300 rounded h-2 mt-4">
                        <div class="bg-blue-600 h-2 rounded" :style="{ width: progress + '%' }"></div>
                    </div>
                    <div class="text-xl">
                        @{{ currentCard.question }}
                    </div>

                    <div v-if="showAnswer" class="bg-gray-100 p-3 rounded">
                        <div class="font-bold text-lg">@{{ currentCard.answer }}</div>

                        <div class="flex flex-col mt-10 gap-2">
                            <button @click="answer(true)" class="btn btn-primary rounded-full">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons.svg') }}#thumb-up"></use>
                                </svg>
                                I got it right!
                            </button>
                            <button @click="answer(false)" class="btn btn-soft rounded-full">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons.svg') }}#thumb-down"></use>
                                </svg>
                                May be next time...
                            </button>
                        </div>
                    </div>

                    <div v-else>
                        <button @click="reveal()" class="bg-blue-500 text-white px-4 py-2 rounded">Reveal Answer</button>
                    </div>

                </div>

                <!-- Final result screen -->
                <div v-if="finished" class="p-4 text-center space-y-4">
                    <div class="text-2xl font-bold text-green-700">Quiz Completed!</div>
                    <div class="text-lg">
                        You got <strong>@{{ correctCount }}</strong> correct out of <strong>@{{ total }}</strong>.
                    </div>
                    <div class="text-sm text-gray-500">
                        Wrong answers: <strong>@{{ wrongCount }}</strong>
                    </div>

                    <button wire:navigate href="{{ route('deck.show', ['deckId' => $deck->id]) }}" class="btn btn-primary mt-4">
                        Back to Deck
                    </button>
                </div>
            </div>
            `
        }).mount('#vue-app');
    }
</script>
@endpush