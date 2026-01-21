<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthMahasiswaController extends Controller
{
    public function __construct()
    {
        if (!session()->has('captcha')) {
            $this->generateCaptcha();
        }
    }

    private function generateCaptcha()
    {
        $code = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5));
        session(['captcha' => $code]);
    }

    // ===============================
    // 🔐 GENERATE GAMBAR CAPTCHA
    // ===============================
    public function captchaImage()
    {
        $code = session('captcha');

        $width = 200;
        $height = 60;
        $image = imagecreatetruecolor($width, $height);

        $bg = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 30, 30, 30);

        imagefill($image, 0, 0, $bg);

        // 🧠 PATH FONT
        $font = public_path('fonts/arial.ttf');

        // Garis acak
        for ($i = 0; $i < 6; $i++) {
            $lineColor = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
            imageline($image, rand(0, 200), rand(0, 60), rand(0, 200), rand(0, 60), $lineColor);
        }

        // Titik noise
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand(0, 200), rand(0, 60), imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255)));
        }

        // Tulis huruf satu-satu miring & acak
        $x = 20;
        for ($i = 0; $i < strlen($code); $i++) {
            $angle = rand(-25, 25);
            $size = rand(20, 28);
            imagettftext($image, $size, $angle, $x, rand(40, 55), $textColor, $font, $code[$i]);
            $x += 30;
        }

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
        exit;
    }

    public function refreshCaptcha()
    {
        $this->generateCaptcha();
        return redirect()->back();
    }

    // ===============================
    // LOGIN
    // ===============================
    public function login(Request $request)
    {
        // CEK CAPTCHA
        if (strtoupper($request->captcha) !== session('captcha')) {
            $this->generateCaptcha();
            return back()->with('error', 'Kode CAPTCHA salah');
        }

        $nim = trim($request->nim);

        if (!preg_match('/^\d{2}\.\d{2}\.\d{1,20}$/', $nim)) {
            $this->generateCaptcha();
            return back()->with('error', 'Format NIM tidak valid');
        }

        $data = DB::table('mahasiswa')->where('nim', $nim)->first();

        if (!$data) {
            DB::table('mahasiswa')->insert([
                'nim'      => $nim,
                'nama'     => '-',
                'fakultas' => '-',
                'jurusan'  => '-',
                'alamat'    => '-',
                'no_hp'     => '-',
                'tempat_tanggal_lahir' => '-',
                'email'     => '-',
                'jenis'     => '-',
                'agama'    => '-',
                'judul_karya' => '-',
            ]);

            $data = DB::table('mahasiswa')->where('nim', $nim)->first();
        }

        session(['mahasiswa' => $data]);

        $this->generateCaptcha();

        return redirect('/dashboard');
    }
}
