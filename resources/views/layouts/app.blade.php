<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    {{-- @if (Request::is('dashboard'))
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
        </script>
    @endif --}}
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @if (Request::is('dashboard'))
        <script type="module" src="{{ config('app.url')."/assets/js/dashboard.js" }}"></script>
    @elseif (Request::is('buat-dokumen/invoice'))
        <script>
            $("#add-invoice-btn").click(function() {
                var invoiceInput = `
        <div class="mb-3">
            <label for="invoice[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Name</label>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="invoice_name[]" required>
        </div>
        <div class="mb-3">
            <label for="invoice_description[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Description</label>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="invoice_description[]" required>
        </div>
        <div class="mb-3">
            <label for="invoice_category[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Category</label>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="invoice_category[]" required>
        </div>
        <div class="mb-3">
            <label for="invoice_fee[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Fee</label>
            <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="invoice_fee[]" required>
        </div>
        <hr class="my-4">`;
                $("#invoices-container").append(invoiceInput);
            });

            $("#add-additional-info-btn").click(function() {
                var additionalInfoInput = `
        <div class="mb-3">
            <label for="additional_information[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Informasi Tambahan</label>
            <input type='text' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="additional_information[]" required>
        </div>`;
                $("#additional-info-container").append(additionalInfoInput);
            });
        </script>
    @elseif (Request::is('buat-dokumen/kwitansi'))
        <script>
            function formatRupiah(input) {
                // Menghilangkan semua karakter selain angka
                var value = input.value.replace(/[^\d]/g, '');

                // Format angka dengan titik setiap 3 digit dari kanan
                value = value.toString().split('').reverse().join('').replace(/\d{3}(?!$)/g, '$&.').split('').reverse().join(
                    '');

                // Menambahkan "Rp " di awal angka
                input.value = 'Rp ' + value;
            }

            $("#add-additional-info-btn").click(function() {
                var additionalInfoInput = `
<div class="mb-3">
<label for="catatan[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Informasi Tambahan</label>
<input type='text' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="additional_information[]" required>
</div>`;
                $("#additional-info-container").append(additionalInfoInput);
            });
        </script>
    @endif

</body>

</html>
