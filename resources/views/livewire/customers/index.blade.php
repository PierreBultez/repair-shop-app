<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Customer;

new class extends Component {
    use WithPagination;

    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();

        session()->flash('success', 'Client supprimé avec succès!');
    }

    public function with(): array
    {
        return [
            'customers' => Customer::query()
                ->orderBy('last_name')
                ->paginate(10)
        ];
    }
}; ?>

<div>
    <flux:main>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Nouveau client
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-100 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($customers->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Aucun client trouvé.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Modifier</a>
                                            <button
                                                wire:click="deleteCustomer({{ $customer->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce client ?"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            >
                                                Supprimer
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </flux:main>
</div>
