<x-layouts.app>
    <div class="container-app">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Transação</h1>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Descrição</label>
                            <input type="text" 
                                   name="description" 
                                   class="form-input" 
                                   value="{{ old('description', $transaction->description) }}" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Valor</label>
                            <input type="number" 
                                   name="amount" 
                                   class="form-input" 
                                   value="{{ old('amount', $transaction->amount / 100) }}" 
                                   step="0.01" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Data</label>
                            <input type="date" 
                                   name="date" 
                                   class="form-input" 
                                   value="{{ old('date', $transaction->date->format('Y-m-d')) }}" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipo</label>
                            <select name="type" class="form-select" required>
                                <option value="income" {{ $transaction->type === 'income' ? 'selected' : '' }}>Receita</option>
                                <option value="expense" {{ $transaction->type === 'expense' ? 'selected' : '' }}>Despesa</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Categoria</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ $transaction->category_id === $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Conta</label>
                            <select name="account_id" class="form-select" required>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" 
                                            {{ $transaction->account_id === $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Transação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app> 