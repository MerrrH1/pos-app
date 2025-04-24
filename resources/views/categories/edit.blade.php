<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300">Nama Kategori</label>
                        <input type="text" name="name" id="name"
                            class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white"
                            value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('categories.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
