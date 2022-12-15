<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Donasi &raquo; {{ $item->program->title }} by {{ $item->user_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full rounded overflow-hidden shadow-lg px-6 py-6 bg-white">
                <div class="text-center">
                    <h3>Menunggu Konfirmasi</h3>
                    <p class="text-sm text-gray-500">Berakhir Tanggal</p>
                    <p class="uppercase ">6 Juni 2022</p>
                </div>
                <div class="mb-5 border-b-2 flex justify-between border-blue-400">
                    <div>
                        <p class="text-left">Id : <span class="uppercase">{{ $item->id }}</span> </p>
                    </div>
                    <div>
                        <p class="text-right">Status : <span class="uppercase">{{ $item->status }}</span> </p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
                    {{-- <div class="w-full md:w-1/6 px-4 mb-4 md:mb-0">
                        <img src="{{ $item->program->banner_program }}" alt="" class="w-full rounded">
                    </div> --}}
                    <div class="w-full mx-auto md:w-5/6 px-4 mb-4 md:mb-0">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Nama Program
                                </label>
                                <input value="{{ $item->program->title }}" name="title"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Nama Donatur
                                </label>
                                <input value="{{ $item->user->name }}" name="title"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Nomor Telphone
                                </label>
                                <input value="{{ $item->user->no_wa }}" name="title"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Email
                                </label>
                                <input value="{{ $item->user->email }}" name="title"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Jumlah Donasi
                                </label>
                                <input value="{{ number_format($item->amount_final) }}" name="amount_final"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Payment Url
                                </label>
                                <input value="{{ $item->payment_url }}" name="title"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Doa Donatur
                                </label>
                                <textarea name="" id="" cols="96" rows="5">{{ $item->doa_donatur }}</textarea>
                            </div>
                        </div>

                        <div class="w-1/6">
                            <div class="text-sm mb-1">Ubah Status</div>
                            <a href="{{ route('transactions.changeStatus', ['id' => $item->id, 'status' => 'success']) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                Success
                            </a>
                            <a href="{{ route('transactions.changeStatus', ['id' => $item->id, 'status' => 'pending']) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                Pending
                            </a>
                            <a href="{{ route('transactions.changeStatus', ['id' => $item->id, 'status' => 'expired']) }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                Expired
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
