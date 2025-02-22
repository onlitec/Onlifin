<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Acesse sua conta') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Ou') }}
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                {{ __('crie uma nova conta') }}
            </a>
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit.prevent="authenticate" class="space-y-6">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                wire:model.live="email" 
                id="email" 
                type="email" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Senha')" />
            <div class="relative">
                <x-text-input 
                    wire:model="password" 
                    id="password" 
                    :type="$showPassword ? 'text' : 'password'"
                    required 
                    autocomplete="current-password" 
                />
                <button 
                    type="button"
                    wire:click="$toggle('showPassword')"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($showPassword)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        @endif
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    wire:model="remember" 
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                >
                <span>{{ __('Lembrar-me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button type="submit" class="w-full justify-center">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500">{{ __('Novo no') }} {{ config('app.name') }}?</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('register') }}" class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __('Criar uma conta') }}
            </a>
        </div>
    </div>
</div> 