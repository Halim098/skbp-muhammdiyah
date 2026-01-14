<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>

<body class="bg-blue-50 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-700 text-white flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-blue-600">
            SKBP Muhammadiyah
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/dashboard" class="block px-4 py-2 rounded hover:bg-blue-600">
                Dashboard
            </a>
            <a href="/admin/dokumen" class="block px-4 py-2 rounded hover:bg-blue-600">
                Verifikasi Dokumen
            </a>
            <a href="/admin/hardcopy" class="block px-4 py-2 rounded hover:bg-blue-600">
                Validasi Hardcopy
            </a>
            <a href="/admin/skbp" class="block px-4 py-2 rounded hover:bg-blue-600">
                SKBP Valid
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-blue-600 text-white flex justify-between items-center px-6 py-4">
            <!-- kiri -->
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold">
                    {{ 'Admin Panel' }}
                </h1>
            </div>

            <!-- kanan -->
            <div class="font-bold flex items-center gap-6">
                <span class="font-semibold">
                    {{ session('admin')->username ?? ' ' }}
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="bg-white text-blue-700 px-3 py-1 rounded hover:bg-blue-100">
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