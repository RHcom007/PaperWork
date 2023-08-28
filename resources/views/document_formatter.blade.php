<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Document Formatter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ?? MAIN CONTAINER --}}

                    <div class="flex flex-warp w-25 h-100 justify-content-center align-items-center">
                        <!-- Membuat Buat pertama dengan tautan ?action=invoice -->
                        <a href="/format/buat-dokumen"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 mx-2">Buat
                            Buat Format Dokumen</a>

                        <div class="relative overflow-x-auto">
                        </div>

                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tbl-kwitansi">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                {{-- <tr>
                                    <th scope="col" class="px-6 py-2 text-center text-lg" colspan="5">
                                        Invoice
                                    </th>
                                </tr> --}}
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Judul
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Keterangan
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Tanggal dibuat
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $dokumen)
                                    <tr class="py-5">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4"> {{ $dokumen->judul }} </td>
                                        <td class="px-6 py-4"> {{ $dokumen->keterangan }} </td>
                                        <td class="px-6 py-4"> {{ $dokumen->created_at }} </td>

                                        <td class="px-6 py-4 text-right">
                                            <a href="/format/{{$dokumen->id}}/buat-dokumen"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Tambah</a>
                                            <a href="/format/{{$dokumen->id}}/cetak-dokumen"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 fw-bold"> Data tidak di temukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
