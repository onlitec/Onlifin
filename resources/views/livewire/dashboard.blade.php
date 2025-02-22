<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Despesas do Dia -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Despesas de Hoje</h3>
                    <div class="mt-6 space-y-4">
                        @forelse($todayExpenses as $expense)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $expense->description }}</p>
                                    <p class="text-sm text-gray-500">{{ $expense->category->name }}</p>
                                </div>
                                <span class="text-red-600 font-medium">
                                    R$ {{ number_format($expense->amount, 2, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Nenhuma despesa para hoje</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Receitas do Dia -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Receitas de Hoje</h3>
                    <div class="mt-6 space-y-4">
                        @forelse($todayIncomes as $income)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $income->description }}</p>
                                    <p class="text-sm text-gray-500">{{ $income->category->name }}</p>
                                </div>
                                <span class="text-green-600 font-medium">
                                    R$ {{ number_format($income->amount, 2, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Nenhuma receita para hoje</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendário -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900">Calendário Financeiro</h3>
                
                <div class="mt-6">
                    <div class="grid grid-cols-7 gap-px">
                        @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $day)
                            <div class="text-center py-2 bg-gray-50">
                                <span class="text-sm font-medium text-gray-900">{{ $day }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-px mt-px">
                        @php
                            $startOfMonth = \Carbon\Carbon::parse($selectedDate)->startOfMonth();
                            $endOfMonth = \Carbon\Carbon::parse($selectedDate)->endOfMonth();
                            $currentDay = $startOfMonth->copy()->startOfWeek();
                            $today = \Carbon\Carbon::today();
                        @endphp

                        @while($currentDay <= $endOfMonth)
                            @php
                                $isToday = $currentDay->isSameDay($today);
                                $isCurrentMonth = $currentDay->month === $startOfMonth->month;
                                
                                $dayExpenses = $monthTransactions['expenses']->where('due_date', $currentDay->format('Y-m-d'));
                                $dayIncomes = $monthTransactions['incomes']->where('due_date', $currentDay->format('Y-m-d'));
                            @endphp

                            <div 
                                wire:click="openFormModal('{{ $currentDay->format('Y-m-d') }}')"
                                class="min-h-[100px] p-2 {{ $isCurrentMonth ? 'bg-white' : 'bg-gray-50' }} 
                                       {{ $isToday ? 'ring-2 ring-blue-500' : '' }} 
                                       hover:bg-gray-50 cursor-pointer"
                            >
                                <span class="text-sm {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }}">
                                    {{ $currentDay->format('d') }}
                                </span>

                                @if($dayExpenses->count() > 0)
                                    <div class="mt-1">
                                        <span class="text-xs text-red-600">
                                            {{ $dayExpenses->count() }} despesa(s)
                                        </span>
                                    </div>
                                @endif

                                @if($dayIncomes->count() > 0)
                                    <div class="mt-1">
                                        <span class="text-xs text-green-600">
                                            {{ $dayIncomes->count() }} receita(s)
                                        </span>
                                    </div>
                                @endif
                            </div>

                            @php
                                $currentDay->addDay();
                            @endphp
                        @endwhile
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Formulário -->
    <div x-data="{ show: @entangle('showFormModal') }">
        <div
            x-show="show"
            x-transition
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
        >
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

                <div class="relative bg-white rounded-lg max-w-lg w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Novo Lançamento - {{ $selectedDate }}
                        </h3>

                        <form wire:submit="saveTransaction" class="mt-6 space-y-4">
                            <!-- Tipo de Transação -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select wire:model="transactionType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="expense">Despesa</option>
                                    <option value="income">Receita</option>
                                </select>
                            </div>

                            <!-- Valor -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Valor</label>
                                <input type="number" step="0.01" wire:model="formData.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Descrição -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                <input type="text" wire:model="formData.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Observação -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Observação</label>
                                <textarea wire:model="formData.observation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model="formData.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="pending">Pendente</option>
                                    <option value="paid">Pago</option>
                                </select>
                            </div>

                            <!-- Tipo (Fixo/Variável) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select wire:model="formData.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="fixed">Fixo</option>
                                    <option value="variable">Variável</option>
                                </select>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button
                                    type="button"
                                    x-on:click="show = false"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                                >
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 