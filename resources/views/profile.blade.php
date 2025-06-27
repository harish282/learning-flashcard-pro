<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight py-3 px-6">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 px-3 md:px-0">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        API Token
                    </h2>
                    <div class="mt-1">
                        <p>{{ __('Your current api token. This token can be used to authenticate requests to the API endpoints.') }}</p>
                        <p class="bg-gray-200 text-xs border rounded p-3">{{ $token}}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
