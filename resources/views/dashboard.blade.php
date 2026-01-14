@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Mahasiswa</h1>

{{-- TAHAP 1 --}}
<div class="mb-8 p-6 bg-white rounded-xl shadow">
    <h2 class="font-bold text-lg mb-2">Tahap 1 — Data Mahasiswa</h2>

    @if($dataLengkap)
    <p class="text-green-600 font-semibold">✔ Data mahasiswa sudah lengkap</p>
    @else
    <p class="text-red-600 font-semibold mb-2">
        ✖ Data mahasiswa belum lengkap
    </p>
    <a href="/data-mahasiswa"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded">
        Lengkapi Data Mahasiswa
    </a>
    @endif
</div>

{{-- TAHAP 2 --}}
<div class="p-6 bg-white rounded-xl shadow mb-8">
    <h2 class="font-bold text-lg mb-4">Tahap 2 — Upload Dokumen</h2>

    @if(!$dataLengkap)
    <p class="text-red-600 font-semibold mb-2">
        ✖ Isi Data mahasiswa terlebih dahulu sebelum upload dokumen.
    </p>

    {{-- ================= BUKU ================= --}}
    @elseif($mahasiswa->jenis === 'buku')
    <p class="font-semibold mb-2 text-red-700">
        ⚠ Harap melengkapi dokumen dalam waktu 7 hari karena dokumen terhapus otomatis oleh sistem.
    </p>

    @php
    $listBuku = [
    'pendahuluan' => 'Pendahuluan',
    'buku_full' => 'Buku Lengkap',
    'surat' => 'Scan Formulir Perpustakaan Terpadu',
    'bukti_sumbangan' => 'Bukti Sumbangan Buku',
    ];
    @endphp

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Dokumen</th>
                <th class="border p-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listBuku as $key => $label)
            <tr>
                <td class="border p-2">{{ $label }}</td>
                <td class="border p-2 text-center">
                    @if(!isset($dokumen[$key]))
                    <span class="text-gray-500">Belum Upload</span>
                    @else
                    @switch($dokumen[$key]->status)
                    @case('diterima')
                    <span class="text-green-600 font-semibold">✔ Diterima</span>
                    @break
                    @case('ditolak')
                    <span class="text-red-600 font-semibold">✖ Ditolak</span>
                    @break
                    @default
                    <span class="text-yellow-500 font-semibold">⏳ Menunggu Verifikasi</span>
                    @endswitch
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/dokumen" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Upload Dokumen Buku
    </a>

    {{-- ================= ARTIKEL ================= --}}
    @elseif($mahasiswa->jenis === 'artikel')
    <p class="font-semibold mb-2 text-red-700">
        ⚠ Harap melengkapi dokumen dalam waktu 7 hari karena dokumen terhapus otomatis oleh sistem.
    </p>

    @php
    $listArtikel = [
    'pendahuluan' => 'Pendahuluan',
    'artikel_full' => 'Artikel Lengkap',
    'surat' => 'Scan Formulir Perpustakaan Terpadu',
    'bukti_sumbangan' => 'Bukti Sumbangan Buku',
    ];
    @endphp

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Dokumen</th>
                <th class="border p-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listArtikel as $key => $label)
            <tr>
                <td class="border p-2">{{ $label }}</td>
                <td class="border p-2 text-center">
                    @if(!isset($dokumen[$key]))
                    <span class="text-gray-500">Belum Upload</span>
                    @else
                    @switch($dokumen[$key]->status)
                    @case('diterima')
                    <span class="text-green-600 font-semibold">✔ Diterima</span>
                    @break
                    @case('ditolak')
                    <span class="text-red-600 font-semibold">✖ Ditolak</span>
                    @break
                    @default
                    <span class="text-yellow-500 font-semibold">⏳ Menunggu Verifikasi</span>
                    @endswitch
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/dokumen" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Upload Dokumen Artikel
    </a>

    {{-- ================= SKRIPSI ================= --}}
    @else
    <p class="font-semibold mb-2 text-red-700">
        ⚠ Harap melengkapi dokumen dalam waktu 7 hari karena dokumen terhapus otomatis oleh sistem.
    </p>

    @php
    $list = [
    'pendahuluan' => 'Pendahuluan',
    'bab1' => 'ISI BAB I',
    'bab2' => 'ISI BAB II',
    'bab3' => 'ISI BAB III',
    'bab4' => 'ISI BAB IV',
    'bab5' => 'ISI BAB V',
    'lampiran' => 'Lampiran',
    'abstraksi' => 'Abstraksi',
    'jurnal' => 'Jurnal',
    'surat' => 'Scan Formulir Perpustakaan Terpadu',
    'skripsi_full' => 'Skripsi Lengkap',
    'bukti_sumbangan' => 'Bukti Sumbangan',
    ];
    @endphp

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Dokumen</th>
                <th class="border p-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $key => $label)
            <tr>
                @if ($label === 'Jurnal')
                <td class="border p-2">
                    {{ $label }}
                    <span class="bg-yellow-300 text-yellow-900 text-xs font-semibold px-2 py-0.5 rounded">
                        Jika Ada
                    </span>
                </td>
                @else
                <td class="border p-2">{{ $label }}</td>
                @endif

                <td class="border p-2 text-center">
                    @if(!isset($dokumen[$key]))
                    <span class="text-gray-500">Belum Upload</span>
                    @else
                    @switch($dokumen[$key]->status)
                    @case('diterima')
                    <span class="text-green-600 font-semibold">✔ Diterima</span>
                    @break
                    @case('ditolak')
                    <span class="text-red-600 font-semibold">✖ Ditolak</span>
                    @break
                    @default
                    <span class="text-yellow-500 font-semibold">⏳ Menunggu Verifikasi</span>
                    @endswitch
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/dokumen" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Upload Dokumen Skripsi
    </a>
    @endif
</div>


{{-- TAHAP 3 --}}
<div class="p-6 bg-white rounded-xl shadow mb-8" id="tahap-3">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-lg">Tahap 3 — Penyerahan Hard Copy</h2>

        {{-- STATUS --}}
        @if(!$hardcopy)
        <span class="text-gray-500 text-sm">Belum Upload</span>
        @elseif($hardcopy->valid == 'tidak valid')
        <span class="text-yellow-600 text-sm font-semibold">⏳ Menunggu Validasi</span>
        @else
        <span class="text-green-600 text-sm font-semibold">✔ Sudah Valid</span>
        @endif
    </div>

    @if($hardcopy)
    <div class="border rounded-lg p-4 bg-gray-50">
        <p class="font-semibold mb-2">Metode yang dipilih:</p>

        <p class="text-gray-800">
            @if($hardcopy->pilihan === 'Penyerahan Langsung')
            📦 Silahkan antar dokumen ke perpustakaan
            @else
            🖨️ Kirimkan file dan bukti pembayaran ke ....
            @endif
        </p>

        @if($hardcopy->valid == 'tidak valid')
        <p class="text-sm text-yellow-600 mt-2">
            ⏳ Menunggu validasi oleh admin perpustakaan.
        </p>
        @else
        <p class="text-sm text-green-600 mt-2">
            ✔ Hard copy telah divalidasi.
        </p>
        @endif
    </div>

    @else
    <p class="text-gray-700 mb-4">
        Silakan pilih salah satu metode penyerahan hard copy skripsi berikut:
    </p>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-2 rounded">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('hardcopy.store') }}" method="POST" class="space-y-3">
        @csrf
        <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">

        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
            <input type="radio" name="pilihan" value="Penyerahan Langsung" required>
            <div>
                <p class="font-semibold">Penyerahan Langsung di Perpustakaan</p>
                <p class="text-sm text-gray-600">
                    Mahasiswa menyerahkan hard copy skripsi secara langsung ke Perpustakaan.
                </p>
            </div>
        </label>

        <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
            <input type="radio" name="pilihan" value="Cetak di Perpustakaan" required>
            <div>
                <p class="font-semibold">Cetak dan Jilid di Perpustakaan</p>
                <p class="text-sm text-gray-600">
                    Hard copy dicetak dan dijilid oleh pihak Perpustakaan
                    <span class="italic">(dikenakan biaya sesuai ketentuan)</span>.
                </p>
            </div>
        </label>

        <button class="mt-4 bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
            Simpan Pilihan
        </button>
    </form>
    @endif
</div>


{{-- TAHAP 4 --}}
<div class="p-6 bg-white rounded-xl shadow mb-8">
    <h2 class="font-bold text-lg mb-2">Tahap 4 — Cetak SKBP</h2>

    <p class="text-gray-600 mb-3">
        Fitur cetak SKBP akan tersedia setelah seluruh tahapan sebelumnya
        diselesaikan dan diverifikasi oleh pihak terkait.
    </p>

    @if($skbpReady)
    <a href="{{ route('admin.skbp.cetak',  $mahasiswa->nim) }}"
        target="_blank"
        class="bg-green-600 text-white px-3 py-1 rounded">
        🖨 Cetak SKBP
    </a>
    @else
    <button
        class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
        disabled>
        Cetak SKBP
    </button>
    @endif
</div>



@endsection