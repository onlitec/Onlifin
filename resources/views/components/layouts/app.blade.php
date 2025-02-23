<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Onlifin') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Debug -->
    <script>
        console.log('Assets loaded');
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded');
            const computedStyle = window.getComputedStyle(document.body);
            console.log('Body background:', computedStyle.backgroundColor);
        });
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="//unpkg.com/imask"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo e Nome -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="text-xl font-bold text-gray-900">Onlifin</span>
                    </a>
                </div>

                <!-- Menu do Usuário -->
                <div class="flex items-center">
                    <div class="relative" x-data="{ open: false }">
                        <!-- Botão do Menu -->
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>

                        <!-- Menu Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                            
                            <!-- Link para Configurações (se for admin) -->
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="ri-settings-3-line mr-2"></i>
                                Configurações
                            </a>
                            @endif

                            <!-- Botão de Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="ri-logout-box-r-line mr-2"></i>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar e Conteúdo Principal -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen">
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                    <i class="ri-dashboard-line mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('transactions') }}"
                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('transactions*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-exchange-funds-line mr-3"></i>
                    Transações
                </a>

                <a href="{{ route('categories') }}"
                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('categories*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-price-tag-3-line mr-3"></i>
                    Categorias
                </a>

                <a href="{{ route('accounts') }}"
                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('accounts*') ? 'bg-gray-100' : '' }}">
                    <i class="ri-bank-line mr-3"></i>
                    Contas
                </a>
            </nav>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    <script src="https://unpkg.com/imask"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 