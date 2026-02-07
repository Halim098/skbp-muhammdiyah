<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'SKBP' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<style>
    /* Container utama Select2 */
    .select2-container .select2-selection--single {
        height: 48px !important;
        /* sama dengan input py-3 */
        padding: 10px 16px !important;
        /* px-4 py-3 */
        border-radius: 0.375rem;
        /* rounded */
        border: 1px solid #e5e7eb;
        /* gray-200 */
        display: flex;
        align-items: center;
    }

    /* Teks di dalam */
    .select2-selection__rendered {
        line-height: normal !important;
        padding-left: 0 !important;
    }

    /* Panah dropdown */
    .select2-selection__arrow {
        height: 48px !important;
    }
</style>


<body class="bg-green-50 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-green-700 text-white flex flex-col">
        <div class="p-6 border-b border-green-600 flex items-center gap-3 justify-center">
            <img src="{{ asset('favicon.png') }}" class="h-10">
            <span class="text-xl font-bold">
                SKBP Muhammadiyah
            </span>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="/dashboard" class="block px-4 py-2 rounded hover:bg-green-600">
                Dashboard
            </a>
            <a href="/data-mahasiswa" class="block px-4 py-2 rounded hover:bg-green-600">
                Data Mahasiswa
            </a>
            <a href="/dokumen" class="block px-4 py-2 rounded hover:bg-green-600">
                Dokumen
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-green-600 text-white flex justify-between items-center px-6 py-4">
            <!-- kiri -->
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>

            <!-- kanan -->
            <div class="font-bold flex items-center gap-6">
                <span class="font-semibold">
                    NIM: {{ session('mahasiswa')->nim ?? '-' }}
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="bg-white text-green-700 px-3 py-1 rounded hover:bg-green-100">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select-search').select2({
                placeholder: 'Ketik untuk mencari...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</body>

</html>