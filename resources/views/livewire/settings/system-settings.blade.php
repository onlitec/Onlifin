<div>
    <div class="card">
        <h2 class="card-title">Configurações do Sistema</h2>
        
        <!-- Seção de Configurações Gerais -->
        <div class="card-section">
            <h3 class="card-section-title">Configurações Gerais</h3>
            <div class="space-y-4">
                <p class="text-label">
                    Esta seção está em desenvolvimento. Em breve você poderá gerenciar:
                </p>
                <ul class="space-y-2">
                    <li class="list-item">
                        <span class="text-value">Configurações de notificações</span>
                    </li>
                    <li class="list-item">
                        <span class="text-value">Preferências do sistema</span>
                    </li>
                    <li class="list-item">
                        <span class="text-value">Gerenciamento de usuários</span>
                    </li>
                    <li class="list-item">
                        <span class="text-value">Backup e restauração</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Seção de Usuários -->
        <div class="card-section">
            <h3 class="card-section-title">Usuários do Sistema</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="list-item">
                    <p class="text-label">Total de usuários</p>
                    <p class="text-value">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Administradores</p>
                    <p class="text-value">{{ \App\Models\User::where('is_admin', true)->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Seção de Sistema -->
        <div class="card-section">
            <h3 class="card-section-title">Informações do Sistema</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="list-item">
                    <p class="text-label">Versão do PHP</p>
                    <p class="text-value">{{ PHP_VERSION }}</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Versão do Laravel</p>
                    <p class="text-value">{{ app()->version() }}</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Ambiente</p>
                    <p class="text-value">{{ app()->environment() }}</p>
                </div>
                <div class="list-item">
                    <p class="text-label">Timezone</p>
                    <p class="text-value">{{ config('app.timezone') }}</p>
                </div>
            </div>
        </div>
    </div>
</div> 