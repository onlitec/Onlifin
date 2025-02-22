<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurações do Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Configurações de Email
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Configure as definições do servidor de email para envio de notificações.
                            </p>
                        </header>

                        <form wire:submit="saveSettings" class="mt-6 space-y-6">
                            <div>
                                <x-input-label for="smtp_host" value="Servidor SMTP" />
                                <x-text-input wire:model="smtp_host" id="smtp_host" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('smtp_host')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="smtp_port" value="Porta SMTP" />
                                <x-text-input wire:model="smtp_port" id="smtp_port" type="number" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('smtp_port')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="smtp_username" value="Usuário SMTP" />
                                <x-text-input wire:model="smtp_username" id="smtp_username" type="email" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('smtp_username')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="smtp_password" value="Senha SMTP" />
                                <x-text-input wire:model="smtp_password" id="smtp_password" type="password" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('smtp_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="smtp_encryption" value="Criptografia" />
                                <select wire:model="smtp_encryption" id="smtp_encryption" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                                <x-input-error :messages="$errors->get('smtp_encryption')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mail_from_address" value="Email Remetente" />
                                <x-text-input wire:model="mail_from_address" id="mail_from_address" type="email" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('mail_from_address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mail_from_name" value="Nome Remetente" />
                                <x-text-input wire:model="mail_from_name" id="mail_from_name" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('mail_from_name')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Salvar</x-primary-button>

                                @if (session('success'))
                                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div> 