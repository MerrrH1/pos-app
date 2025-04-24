<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Satuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->role === 'super_admin')
                        <div class="mb-4">
                            <a href="{{ route('units.create') }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Satuan</a>
                        </div>
                    @endif
                    <table class="table-auto min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">Nama Satuan</th>
                                @if (Auth::user()->role === 'super_admin')
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($units as $unit)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $unit->name }}</td>
                                    @if (Auth::user()->role === 'super_admin')
                                        <td class="px-4 py-2">
                                            <a href="{{ route('units.edit', $unit) }}"
                                                class="text-blue-500 hover:underline">Edit</a>
                                            <form action="{{ route('units.destroy', $unit->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:underline ml-2">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
