<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-green-700 text-white flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-green-600">
            SKBP Muhammadiyah
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

</body>

</html>