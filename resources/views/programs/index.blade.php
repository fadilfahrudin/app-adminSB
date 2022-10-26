<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Programs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('programs.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Tambah Program
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">Id</th>
                            <th class="border px-6 py-4">Judul Program</th>
                            <th class="border px-6 py-4">Pemilik Program</th>
                            <th class="border px-6 py-4">Target</th>
                            <th class="border px-6 py-4">Batas Waktu</th>
                            <th class="border px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($program as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id }}</td>
                                <td class="border px-6 py-4">{{ substr($item->title, 0, 35) }}</td>
                                <td class="border px-6 py-4">{{ $item->program_by }}</td>
                                <td class="border px-6 py-4">{{ number_format($item->target_amount) }}</td>
                                <td class="border px-6 py-4">{{ $item->end_program }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('programs.edit', $item->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white py-2 px-2 mx-2 rounded">Ubah
                                    </a>

                                    <form action="{{ route('programs.destroy', $item->id) }}" method="POST"
                                        class="inline-block">

                                        {!! method_field('delete') . csrf_field() !!}
                                        <button type="submit"
                                            class="inline-block bg-red-500 hover:bg-red-900 text-white
                                            py-2 px-2 mx-2 rounded">Hapus</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border text-center p-5">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $program->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
