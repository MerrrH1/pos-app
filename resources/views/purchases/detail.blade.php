<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($purchase->date)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Admin</th>
                            <td class="px-4 py-2">{{ $purchase->user ? Str::title($purchase->user->name) : '-' }}
                            </td>
                        </tr>

                        <tr x-data="{ open: false }">
                            <th class="px-4 py-2 text-left align-top">Nama Supplier</th>
                            <td class="px-4 py-2">
                                @if ($purchase->supplier)
                                    {{ $purchase->supplier->name }}
                                @else
                                    <span class="inline-block">-</span>
                                    <button @click="open = !open"
                                        class="ml-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        Ganti Nama Supplier
                                    </button>

                                    <div x-show="open" class="mt-2">
                                        <form
                                            action="{{ route('purchases.setSupplier', ['purchase' => $purchase->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="supplier_id"
                                                class="border border-gray-300 rounded px-2 py-1 dark:bg-gray-700 dark:border-gray-600">
                                                <option value="">-- Pilih Supplier --</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="ml-2 bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                                Simpan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2 text-left">Total</th>
                            <td class="px-4 py-2">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2 text-left">Status</th>
                            <td class="px-4 py-2">
                                @switch($purchase->status)
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
                        </tr>
                        @if ($purchase->status == 'unpaid')
                            <tr>
                                <th class="px-4 py-2 text-left align-top">Ubah Status</th>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <form
                                            action="{{ route('purchases.setStatus', ['purchase' => $purchase->id, 'status' => 'paid']) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah anda yakin menandai transaksi ini sebagai sudah dibayar?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                Tandai Sudah Bayar
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('purchases.setStatus', ['purchase' => $purchase->id, 'status' => 'cancelled']) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah anda yakin menandai transaksi ini sebagai dibatalkan?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="my-4"></div>
            @if ($purchase->status === 'unpaid')
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Tambah Produk') }}
                    </h3>
                    <form method="POST" action="{{ route('purchaseItems.store') }}" class="mb-4">
                        @csrf
                        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="product_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Nama Produk') }}
                                </label>
                                <select id="product_id" name="product_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 rounded-md shadow-sm">
                                    <option value="">{{ __('Pilih Produk') }}</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (Stok:
                                            {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="quantity"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Kuantitas') }}
                                </label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 rounded-md shadow-sm">
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __('Tambah Barang') }}
                        </button>
                    </form>
                </div>
            @endif
            <div class="my-4"></div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @if ($purchase->purchaseItems->count() > 0)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Produk dalam Transaksi') }}</h3>
                    <table
                        class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Produk</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Kuantitas</th>
                                <th class="px-4 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->purchaseItems as $item)
                                <tr>
                                    <form action="{{ route('purchaseItems.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="px-4 py-2 text-left">{{ $item->product->name }}</td>
                                        <td class="px-4 py-2 text-left">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-left">
                                            @if ($purchase->status === 'unpaid')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                    min="1"
                                                    class="w-20 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            @else
                                                {{ $item->quantity }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-left">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        @if ($purchase->status === 'unpaid')
                                            <td class="px-4 py-2 text-left">
                                                <button type="submit"
                                                    class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 transition">
                                                    Simpan
                                                </button>
                                            </td>
                                        @endif
                                    </form>
                                    @if ($purchase->status === 'unpaid')
                                        <td class="px-4 py-2 text-left">
                                            <form action="{{ route('purchaseItems.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus item ini dari transaksi?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Belum ada produk dalam transaksi.') }}</p>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
