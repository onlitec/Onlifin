<div class="auth-card" x-data="{ showPassword: false }">
    <!-- Logo -->
    <div class="auth-logo">
        <h1>Onlifin</h1>
    </div>

    <!-- Título -->
    <h2 class="auth-title">Acesse sua conta</h2>
    <p class="auth-subtitle">
        Ou <a href="{{ route('register') }}" class="auth-link">crie uma nova conta</a>
    </p>

    <form wire:submit.prevent="authenticate">
        @csrf
        <!-- Email -->
        <div class="auth-input-group">
            <input 
                wire:model="email" 
                type="email" 
                class="auth-input" 
                placeholder="E-mail"
                required
            >
            @error('email') 
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Senha -->
        <div class="auth-input-group">
            <input 
                wire:model="password" 
                :type="showPassword ? 'text' : 'password'" 
                class="auth-input" 
                placeholder="Senha"
                required
            >
            @error('password') 
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center">
                <input type="checkbox" wire:model="remember" class="form-checkbox">
                <span class="ml-2 text-sm">Lembrar-me</span>
            </label>
        </div>

        <!-- Botão Login -->
        <button type="submit" class="auth-button">
            Entrar
        </button>

        <!-- Link Registro -->
        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="auth-link">
                Criar nova conta
            </a>
        </div>
    </form>

    @if(config('app.debug'))
        <div class="mt-4 p-4 bg-gray-100 rounded text-sm">
            <p>Debug Info:</p>
            <pre>{{ json_encode([
                'email' => $email,
                'password_length' => strlen($password),
                'remember' => $remember
            ], JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</div>