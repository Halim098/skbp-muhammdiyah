<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login NIM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>

<body class="min-h-screen flex items-center justify-center bg-white">

    <div class="w-full max-w-md border-2 border-green-500 rounded-3xl p-10">

        <form method="POST" action="/login" class="space-y-6">
            @csrf

            <input type="text" name="nim" id="nim"
                placeholder="NIM XX.XX.XXXX"
                maxlength="26"
                class="w-full px-5 py-3 text-center border-2 border-green-500 rounded-xl
    focus:outline-none focus:ring-2 focus:ring-green-400"
                required>

            {{-- CAPTCHA --}}
            <div class="flex items-center gap-3 mt-4">
                <!-- Input captcha -->
                <input
                    type="text"
                    name="captcha"
                    placeholder="Ketik kode di gambar"
                    class="flex-1 px-4 py-2 border-2 border-green-500 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-green-400"
                    required>

                <!-- Gambar captcha -->
                <img
                    src="/captcha"
                    id="captchaImg"
                    class="h-11 w-20 border-2 border-green-500 rounded-lg"
                    alt="Captcha">


                <!-- Tombol refresh -->
                <button
                    type="button"
                    onclick="document.getElementById('captchaImg').src='/captcha?'+Math.random()"
                    class="text-green-600 text-2xl font-bold"
                    title="Refresh CAPTCHA">
                    ↻
                </button>

            </div>


            <button type="submit"
                class="w-full bg-green-500 text-white font-semibold py-3 rounded-lg hover:bg-green-600 transition">
                Masuk
            </button>

        </form>

        @if(session('error'))
        <p class="mt-6 text-center text-red-500 font-semibold">
            {{ session('error') }}
        </p>
        @endif

    </div>

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