<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Onlifin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @livewireStyles

    <style>
        /* Reset e estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        /* Estilos globais */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar melhorada */
        .navbar {
            background-color: white;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            height: 4rem;
        }

        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #4f46e5, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
            height: 100%;
        }

        .nav-link {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            height: 2.5rem;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            color: #4f46e5;
            background-color: #f5f3ff;
        }

        .nav-link.active {
            color: #4f46e5;
            background-color: #f5f3ff;
        }

        /* Container principal melhorado */
        .main-container {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 6rem 1.5rem 2rem;
            flex: 1;
        }

        /* Cards melhorados */
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            padding: 1.5rem;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
            height: fit-content;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Seções dentro dos cards */
        .card-section {
            padding: 1.5rem;
            background-color: #f9fafb;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .card-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
        }

        /* Grid e layouts */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        /* Textos e tipografia */
        .text-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .text-value {
            font-size: 1rem;
            color: #111827;
            font-weight: 500;
        }

        /* Listas */
        .list-item {
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: white;
            margin-bottom: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .list-item:hover {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                Onlifin
            </a>
            
            <div class="navbar-menu">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    Despesas
                </a>
                <a href="{{ route('incomes.index') }}" class="nav-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}">
                    Receitas
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                        Configurações
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="nav-link" style="border: none; background: none; cursor: pointer;">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="main-container">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html> 