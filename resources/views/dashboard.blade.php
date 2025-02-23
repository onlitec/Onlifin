<div>
    <div class="card">
        <h2 class="card-title">Dashboard</h2>
        <p class="text-label mb-6">Bem-vindo, {{ Auth::user()->name }}!</p>
        
        <!-- Seção de Resumo -->
        <div class="card-section">
            <h3 class="card-section-title">Resumo Financeiro</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="list-item">
                    <p class="text-label">Receitas do Mês</p>
                    <p class="text-value">R$ 0,00</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Despesas do Mês</p>
                    <p class="text-value">R$ 0,00</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Saldo do Mês</p>
                    <p class="text-value">R$ 0,00</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Saldo Total</p>
                    <p class="text-value">R$ 0,00</p>
                </div>
            </div>
        </div>

        <!-- Seção de Atividades Recentes -->
        <div class="card-section">
            <h3 class="card-section-title">Atividades Recentes</h3>
            <div class="space-y-2">
                <div class="list-item">
                    <p class="text-label">Nenhuma atividade recente</p>
                </div>
            </div>
        </div>

        <!-- Seção de Links Rápidos -->
        <div class="card-section">
            <h3 class="card-section-title">Links Rápidos</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('expenses.index') }}" class="list-item hover:bg-indigo-50">
                    <p class="text-value">Gerenciar Despesas</p>
                    <p class="text-label">Adicione ou edite suas despesas</p>
                </a>
                <a href="{{ route('incomes.index') }}" class="list-item hover:bg-indigo-50">
                    <p class="text-value">Gerenciar Receitas</p>
                    <p class="text-label">Adicione ou edite suas receitas</p>
                </a>
            </div>
        </div>
    </div>
</div>