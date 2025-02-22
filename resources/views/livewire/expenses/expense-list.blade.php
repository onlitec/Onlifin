<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-900">Despesas</h2>
            <button
                wire:click="openFormModal"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700"
            >
                Nova Despesa
            </button>
        </div>

        <!-- Filtros -->
        <div class="mt-4 bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:model.live="filters.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos</option>
                        <option value="pending">Pendente</option>
                        <option value="paid">Pago</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select wire:model.live="filters.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos</option>
                        <option value="fixed">Fixo</option>
                        <option value="variable">Variável</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Categoria</label>
                    <select wire:model.live="filters.category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Inicial</label>
                    <input 
                        type="date" 
                        wire:model.live="filters.start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Final</label>
                    <input 
                        type="date" 
                        wire:model.live="filters.end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
            </div>
        </div>

        <!-- Lista de Despesas -->
        <div class="mt-6 bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descrição
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categoria
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Valor
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $expense->due_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $expense->description }}
                                @if($expense->observation)
                                    <p class="text-xs text-gray-500">{{ $expense->observation }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $expense->category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $expense->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $expense->status === 'paid' ? 'Pago' : 'Pendente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $expense->type === 'fixed' ? 'Fixo' : 'Variável' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button
                                    wire:click="openFormModal({{ $expense->id }})"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    Editar
                                </button>
                                <button
                                    wire:click="delete({{ $expense->id }})"
                                    wire:confirm="Tem certeza que deseja excluir esta despesa?"
                                    class="ml-4 text-red-600 hover:text-red-900"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Nenhuma despesa encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $expenses->links() }}
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
                            {{ $editingExpense ? 'Editar' : 'Nova' }} Despesa
                        </h3>

                        <form wire:submit="save" class="mt-6 space-y-4">
                            <!-- Campos do formulário (mesmos do dashboard) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data</label>
                                <input 
                                    type="date" 
                                    wire:model="formData.due_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Valor</label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    wire:model="formData.amount"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                <input 
                                    type="text" 
                                    wire:model="formData.description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Categoria</label>
                                <select 
                                    wire:model="formData.category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
                                    <option value="">Selecione...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Observação</label>
                                <textarea 
                                    wire:model="formData.observation"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                ></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select 
                                    wire:model="formData.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
                                    <option value="pending">Pendente</option>
                                    <option value="paid">Pago</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select 
                                    wire:model="formData.type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >
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