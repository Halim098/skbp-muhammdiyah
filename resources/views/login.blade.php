<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login NIM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>

<body
    class="min-h-screen flex items-center justify-center bg-cover bg-center"
    style="background-image: url('{{ asset('bg.png') }}')">

    <!-- overlay gelap -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- CARD LOGIN -->
    <div class="relative w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-10">

        <!-- LOGO -->
        <div class="text-center mb-5 mt-5">
            <img src="{{ asset('favicon.png') }}" class="mx-auto h-14 mb-2">
            <h1 class="text-green-600 font-bold text-xl">SKBP Perpustakaan UMPR</h1>
            <p class="text-sm text-gray-600 mt-2">
                Website Pembuatan<br>
                <span class="font-semibold">SKBP (Surat Keterangan Bebas Pustaka)</span> Universitas Muhammadiyah Palangka Raya
            </p>
        </div>

        <!-- INFO -->
        <!-- <div class="text-sm text-red-500 text-center mb-5">
            Lupa password?<br>
            Silahkan hubungi <span class="italic">Operator Program Studi</span>
            untuk bantuan reset password.
        </div> -->

        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <!-- NIM -->
            <input
                type="text"
                name="nim"
                id="nim"
                placeholder="NIM XX.XX.XXXX"
                maxlength="26"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none text-center"
                required>

            <!-- CAPTCHA -->
            <div class="flex items-center gap-3">
                <input
                    type="text"
                    name="captcha"
                    placeholder="Kode captcha"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-green-400 focus:outline-none"
                    required>

                <img
                    src="/captcha"
                    id="captchaImg"
                    class="h-11 w-24 border rounded-lg bg-white"
                    alt="Captcha">

                <button
                    type="button"
                    onclick="document.getElementById('captchaImg').src='/captcha?'+Math.random()"
                    class="text-green-600 text-xl font-bold"
                    title="Refresh CAPTCHA">
                    ↻
                </button>
            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition">
                Login
            </button>

        </form>

        <!-- ERROR -->
        @if(session('error'))
        <p class="mt-5 text-center text-red-600 font-semibold">
            {{ session('error') }}
        </p>
        @endif

        <!-- FOOTER -->
        <div class="text-center text-xs text-gray-600 mt-6">
            Universitas Muhammadiah Palangka Raya<br>
            2025
        </div>

    </div>

    <!-- FORMAT NIM -->
    <script>
        const nimInput = document.getElementById('nim');
        nimInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            let part1 = value.substring(0, 2);
            let part2 = value.substring(2, 4);
            let part3 = value.substring(4, 24);

            let formatted = part1;
            if (part2) formatted += '.' + part2;
            if (part3) formatted += '.' + part3;

            this.value = formatted;
        });
    </script>

</body>

</html>