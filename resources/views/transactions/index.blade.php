<x-layouts.app>
    <div class="container-app">
        <div class="mb-6 flex items-center justify-between">
            <h1>Transações</h1>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="ri-add-line mr-2"></i>
                Nova Transação
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Data</th>
                                <th class="table-header-cell">Descrição</th>
                                <th class="table-header-cell">Categoria</th>
                                <th class="table-header-cell">Conta</th>
                                <th class="table-header-cell">Valor</th>
                                <th class="table-header-cell">Tipo</th>
                                <th class="table-header-cell">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @forelse($transactions ?? [] as $transaction)
                                <tr class="table-row">
                                    <td class="table-cell">{{ $transaction->date->format('d/m/Y') }}</td>
                                    <td class="table-cell">{{ $transaction->description }}</td>
                                    <td class="table-cell">{{ $transaction->category->name }}</td>
                                    <td class="table-cell">{{ $transaction->account->name }}</td>
                                    <td class="table-cell">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                                    <td class="table-cell">
                                        <span class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                                        </span>
                                    </td>
                                    <td class="table-cell">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-800">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <button type="button" class="text-red-600 hover:text-red-800">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="table-cell text-center">
                                        Nenhuma transação encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 