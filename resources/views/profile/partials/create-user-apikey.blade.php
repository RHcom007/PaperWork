<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('API Token Regenerator') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Informasi tentang token api mu untuk menggunakan API dari web ini.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="api_token" :value="__('Api Token')" />
            <x-text-input id="api_token" name="api_token" type="text" class="mt-1 block w-full" :value="old('api_token', $user->api_token)" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('api_token')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Regenerate') }}</x-primary-button>

            @if (session('status') === 'apikey-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Success.') }}</p>
            @endif
        </div>
    </form>
</section>
