<x-layouts.app>
    <div class="container-app">
        <!-- Totais Gerais -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card bg-green-50">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-green-700 mb-2">Total de Receitas</h3>
                    <p class="text-2xl font-bold text-green-600">
                        R$ {{ number_format($totalIncome / 100, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="card bg-red-50">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-red-700 mb-2">Total de Despesas</h3>
                    <p class="text-2xl font-bold text-red-600">
                        R$ {{ number_format($totalExpenses / 100, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="card bg-blue-50">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Saldo</h3>
                    <p class="text-2xl font-bold {{ ($balance >= 0) ? 'text-green-600' : 'text-red-600' }}">
                        R$ {{ number_format($balance / 100, 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Transações do Dia -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Bloco de Receitas -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Receitas</h2>
                
                <!-- Receitas de Hoje -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-green-700 mb-4">
                            Receitas de Hoje
                            <span class="text-sm font-normal text-gray-600">
                                ({{ now()->format('d/m/Y') }})
                            </span>
                        </h3>
                        @if($todayIncomes->count() > 0)
                            <div class="space-y-3">
                                @foreach($todayIncomes as $income)
                                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg group">
                                        <div class="flex-grow">
                                            <p class="font-medium">{{ $income->description }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $income->category->name }}
                                                <span class="text-xs text-gray-500">
                                                    • {{ $income->account->name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <p class="font-bold text-green-600">
                                                R$ {{ number_format($income->amount / 100, 2, ',', '.') }}
                                            </p>
                                            <a href="{{ route('transactions.edit', $income->id) }}" 
                                               class="btn btn-sm btn-secondary opacity-0 group-hover:opacity-100 transition-opacity"
                                               title="Editar receita">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center">Nenhuma receita para hoje</p>
                        @endif
                    </div>
                </div>

                <!-- Receitas de Amanhã -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-green-700 mb-4">
                            Receitas de Amanhã
                            <span class="text-sm font-normal text-gray-600">
                                ({{ now()->addDay()->format('d/m/Y') }})
                            </span>
                        </h3>
                        @if($tomorrowIncomes->count() > 0)
                            <div class="space-y-3">
                                @foreach($tomorrowIncomes as $income)
                                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg group">
                                        <div class="flex-grow">
                                            <p class="font-medium">{{ $income->description }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $income->category->name }}
                                                <span class="text-xs text-gray-500">
                                                    • {{ $income->account->name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <p class="font-bold text-green-600">
                                                R$ {{ number_format($income->amount / 100, 2, ',', '.') }}
                                            </p>
                                            <a href="{{ route('transactions.edit', $income->id) }}" 
                                               class="btn btn-sm btn-secondary opacity-0 group-hover:opacity-100 transition-opacity"
                                               title="Editar receita">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center">Nenhuma receita para amanhã</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bloco de Despesas -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Despesas</h2>
                
                <!-- Despesas de Hoje -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-red-700 mb-4">
                            Despesas de Hoje
                            <span class="text-sm font-normal text-gray-600">
                                ({{ now()->format('d/m/Y') }})
                            </span>
                        </h3>
                        @if($todayExpenses->count() > 0)
                            <div class="space-y-3">
                                @foreach($todayExpenses as $expense)
                                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg group">
                                        <div class="flex-grow">
                                            <p class="font-medium">{{ $expense->description }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $expense->category->name }}
                                                <span class="text-xs text-gray-500">
                                                    • {{ $expense->account->name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <p class="font-bold text-red-600">
                                                R$ {{ number_format($expense->amount / 100, 2, ',', '.') }}
                                            </p>
                                            <a href="{{ route('transactions.edit', $expense->id) }}" 
                                               class="btn btn-sm btn-secondary opacity-0 group-hover:opacity-100 transition-opacity"
                                               title="Editar despesa">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center">Nenhuma despesa para hoje</p>
                        @endif
                    </div>
                </div>

                <!-- Despesas de Amanhã -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-red-700 mb-4">
                            Despesas de Amanhã
                            <span class="text-sm font-normal text-gray-600">
                                ({{ now()->addDay()->format('d/m/Y') }})
                            </span>
                        </h3>
                        @if($tomorrowExpenses->count() > 0)
                            <div class="space-y-3">
                                @foreach($tomorrowExpenses as $expense)
                                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg group">
                                        <div class="flex-grow">
                                            <p class="font-medium">{{ $expense->description }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $expense->category->name }}
                                                <span class="text-xs text-gray-500">
                                                    • {{ $expense->account->name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <p class="font-bold text-red-600">
                                                R$ {{ number_format($expense->amount / 100, 2, ',', '.') }}
                                            </p>
                                            <a href="{{ route('transactions.edit', $expense->id) }}" 
                                               class="btn btn-sm btn-secondary opacity-0 group-hover:opacity-100 transition-opacity"
                                               title="Editar despesa">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center">Nenhuma despesa para amanhã</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 