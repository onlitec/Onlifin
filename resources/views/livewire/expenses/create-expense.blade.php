<div>
    <form wire:submit="save" class="space-y-6">
        <div>
            <x-input-label for="description" value="Descrição" />
            <x-text-input wire:model="description" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="amount" value="Valor" />
            <x-text-input wire:model="amount" type="number" step="0.01" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="due_date" value="Data de Vencimento" />
            <x-text-input wire:model="due_date" type="date" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="category" value="Categoria" />
            <select wire:model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Selecione uma categoria</option>
                @foreach($categories as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="notes" value="Observações" />
            <textarea wire:model="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-primary-button type="submit">
                Criar Despesa
            </x-primary-button>
        </div>
    </form>
</div> 