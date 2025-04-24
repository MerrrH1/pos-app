<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300">Nama Produk</label>
                        <input type="text" name="name" id="name"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="unit_id" class="block text-gray-700 dark:text-gray-300">Satuan</label>
                        <select name="unit_id" id="unit_id"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 dark:text-gray-300">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 dark:text-gray-300">Harga Jual</label>
                        <input type="number" name="price" id="price"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white"
                            value="{{ old('price') }}">
                        @error('price')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cost" class="block text-gray-700 dark:text-gray-300">Harga Beli</label>
                        <input type="number" name="cost" id="cost"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white"
                            value="{{ old('cost') }}">
                        @error('cost')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-gray-700 dark:text-gray-300">Stok</label>
                        <input type="number" name="stock" id="stock"
                            class="w-full mt-1 p-2 rounded dark:bg-gray-700 dark:text-white"
                            value="{{ old('stock') }}">
                        @error('stock')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('products.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
