<?php

use Livewire\Volt\Component;
use App\Models\Customer;

new class extends Component {
    public ?Customer $customer = null;

    public array $form = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'city' => '',
        'postal_code' => '',
        'company_name' => '',
        'company_tax_id' => '',
        'notes' => '',
        'marketing_consent' => false,
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->customer = Customer::findOrFail($id);
            $this->form = $this->customer->only([
                'first_name', 'last_name', 'email', 'phone', 'address',
                'city', 'postal_code', 'company_name', 'company_tax_id',
                'notes', 'marketing_consent'
            ]);
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'form.first_name' => 'required|string|max:255',
            'form.last_name' => 'required|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.address' => 'nullable|string|max:255',
            'form.city' => 'nullable|string|max:100',
            'form.postal_code' => 'nullable|string|max:20',
            'form.company_name' => 'nullable|string|max:255',
            'form.company_tax_id' => 'nullable|string|max:50',
            'form.notes' => 'nullable|string',
            'form.marketing_consent' => 'boolean',
        ]);

        if ($this->customer) {
            $this->customer->update($this->form);
            session()->flash('success', 'Client mis à jour avec succès!');
        } else {
            Customer::create($this->form);
            session()->flash('success', 'Client créé avec succès!');
        }

        return redirect()->route('customers.index');
    }
}; ?>

<div>
    <flux:main>
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                {{ isset($customer) ? 'Modifier le client' : 'Nouveau client' }}
            </h2>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
            <div class="p-6">
                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prénom -->
                        <div>
                            <flux:label for="first_name">{{ __('Prénom') }}</flux:label>
                            <flux:input wire:model="form.first_name" id="first_name" class="w-full" required />
                            @error('form.first_name') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <flux:label for="last_name">{{ __('Nom') }}</flux:label>
                            <flux:input wire:model="form.last_name" id="last_name" class="w-full" required />
                            @error('form.last_name') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <flux:label for="email">{{ __('Email') }}</flux:label>
                            <flux:input wire:model="form.email" id="email" type="email" class="w-full" />
                            @error('form.email') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <flux:label for="phone">{{ __('Téléphone') }}</flux:label>
                            <flux:input wire:model="form.phone" id="phone" type="tel" class="w-full" />
                            @error('form.phone') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="md:col-span-2">
                            <flux:label for="address">{{ __('Adresse') }}</flux:label>
                            <flux:input wire:model="form.address" id="address" class="w-full" />
                            @error('form.address') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Ville -->
                        <div>
                            <flux:label for="city">{{ __('Ville') }}</flux:label>
                            <flux:input wire:model="form.city" id="city" class="w-full" />
                            @error('form.city') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Code postal -->
                        <div>
                            <flux:label for="postal_code">{{ __('Code postal') }}</flux:label>
                            <flux:input wire:model="form.postal_code" id="postal_code" class="w-full" />
                            @error('form.postal_code') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Entreprise -->
                        <div>
                            <flux:label for="company_name">{{ __('Nom de l\'entreprise') }}</flux:label>
                            <flux:input wire:model="form.company_name" id="company_name" class="w-full" />
                            @error('form.company_name') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- SIRET -->
                        <div>
                            <flux:label for="company_tax_id">{{ __('SIRET') }}</flux:label>
                            <flux:input wire:model="form.company_tax_id" id="company_tax_id" class="w-full" />
                            @error('form.company_tax_id') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <flux:label for="notes">{{ __('Notes') }}</flux:label>
                            <flux:textarea wire:model="form.notes" id="notes" rows="3" class="w-full" />
                            @error('form.notes') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <!-- Consentement marketing -->
                        <div class="md:col-span-2">
                            <flux:checkbox wire:model="form.marketing_consent" id="marketing_consent">
                                {{ __('Ce client accepte de recevoir des communications marketing') }}
                            </flux:checkbox>
                            @error('form.marketing_consent') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <flux:button href="{{ route('customers.index') }}" variant="secondary" class="mr-3">
                            {{ __('Annuler') }}
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            {{ isset($customer) ? __('Mettre à jour') : __('Créer') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</div>
