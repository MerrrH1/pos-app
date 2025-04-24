<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium">No Invoice</label>
                            <input type="text" class="w-full mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-white"
                                   name="invoice_number" value="{{ $invoiceNumber }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Customer</label>
                            <select name="customer_id"
                                    class="w-full mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Tanggal</label>
                            <input type="date" name="date"
                                   class="w-full mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-white"
                                   value="{{ old('date', now()->format('Y-m-d')) }}">
                            @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>