<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->role === 'super_admin' || Auth::user()->role === "sales_admin")
                        <div class="mb-4">
                            <a href="{{ route('transactions.create') }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Transaksi</a>
                        </div>
                    @endif

                    <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">No Invoice</th>
                                <th class="px-4 py-2 text-left">Nama Pelanggan</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Total</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $transaction->invoice_number }}</td>
                                    <td class="px-4 py-2">{{ $transaction->customer->name }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @switch($transaction->status)
                                            @case('paid')
                                                Sudah Bayar
                                            @break
                                            @case('cancelled')
                                                Batal
                                            @break
                                            @default
                                                Belum Bayar
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
