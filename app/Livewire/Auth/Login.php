<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public bool $showPassword = false;

    protected $rules = [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function authenticate()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            // Configura a sessão para expirar quando o navegador fechar
            config(['session.expire_on_close' => true]);
            
            // Se o usuário marcou "lembrar-me", mantém o cookie por 30 dias
            if ($this->remember) {
                cookie()->queue('remember_web', encrypt(auth()->id()), 43200); // 30 dias
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $this->addError('email', trans('auth.failed'));
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }
} 