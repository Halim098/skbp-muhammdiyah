<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-green-50">

<div class="w-full max-w-md bg-white p-10 rounded-3xl shadow">
    <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
        Login Admin
    </h2>

    @if(session('error'))
        <p class="text-red-500 text-center mb-4">
            {{ session('error') }}
        </p>
    @endif

    <form method="POST" action="/admin/login" class="space-y-6">
        @csrf

        <input type="text" name="username"
            placeholder="Username"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-400">

        <input type="password" name="password"
            placeholder="Password"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-400">

        <button
            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">
            Login
        </button>
    </form>
</div>

</body>
</html>
