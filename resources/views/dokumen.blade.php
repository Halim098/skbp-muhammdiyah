@php
function statusIcon($dokumen, $key) {
if (!isset($dokumen[$key])) {
return '<span class="text-gray-400 text-sm">(Belum upload)</span>';
}

return match($dokumen[$key]->status) {
'diterima' => '<span class="text-green-600">✔ Diterima</span>',
'ditolak' => '<span class="text-red-600">✖ Ditolak</span>',
default => '<span class="text-yellow-500">⏳ Menunggu Verifikasi</span>',
};
}

function keterangan($dokumen, $key): string
{
if (!isset($dokumen[$key])) {
return '-';
}

return $dokumen[$key]->keterangan ?: '-';
}

function disableUpload($dokumen, $key) {
if (!isset($dokumen[$key])) return false;
return in_array($dokumen[$key]->status, ['pending', 'diterima']);
}
@endphp


@extends('layouts.app')

@php
$jenis = session('mahasiswa')->jenis;
@endphp


@section('content')
<h1 class="text-2xl font-bold mb-6">Upload Dokumen Skripsi</h1>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(!$isLengkap)
<div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-6">
    <p class="font-semibold mb-2">
        ⚠ Data mahasiswa belum lengkap
    </p>
    <p class="text-sm mb-3">
        Silakan lengkapi data mahasiswa terlebih dahulu sebelum mengunggah dokumen skripsi.
    </p>

    <a href="{{ url('/data-mahasiswa') }}"
        class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Lengkapi Data Mahasiswa
    </a>
</div>
@else

<div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-6">
    <p class="font-semibold mb-2">
        ⚠ Harap melengkapi dokumen dalam waktu 7 hari karena dokumen terhapus otomatis oleh sistem.
    </p>
</div>

@if($jenis === 'buku')
<form action="{{ route('dokumen.upload.buku') }}" method="POST" enctype="multipart/form-data"
    class="bg-white p-6 rounded-lg shadow space-y-5">
    @csrf

    {{-- Pendahuluan --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Pendahuluan
            {!! statusIcon($dokumen,'pendahuluan') !!}
        </label>

        @if(($ket = keterangan($dokumen,'pendahuluan')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded text-sm mb-2">
            ⚠ {{ $ket }}
        </div>
        @endif

        <input type="file" name="pendahuluan" class="form-input w-full"
            {{ disableUpload($dokumen,'pendahuluan') ? 'disabled' : '' }}>
    </div>

    {{-- Buku Lengkap --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Buku Lengkap
            {!! statusIcon($dokumen,'buku_full') !!}
        </label>

        @if(($ket = keterangan($dokumen,'buku_full')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded text-sm mb-2">
            ⚠ {{ $ket }}
        </div>
        @endif

        <input type="file" name="buku_full" class="form-input w-full"
            {{ disableUpload($dokumen,'buku_full') ? 'disabled' : '' }}>
    </div>

    {{-- Formulir Perpustakaan --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Formulir Perpustakaan Terpadu
            {!! statusIcon($dokumen,'surat') !!}
        </label>

        @if(($ket = keterangan($dokumen,'surat')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded text-sm mb-2">
            ⚠ {{ $ket }}
        </div>
        @endif

        <input type="file" name="surat" class="form-input w-full"
            {{ disableUpload($dokumen,'surat') ? 'disabled' : '' }}>
    </div>

    {{-- Bukti Sumbangan --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Bukti Sumbangan Buku
            {!! statusIcon($dokumen,'bukti_sumbangan') !!}
        </label>

        @if(($ket = keterangan($dokumen,'bukti_sumbangan')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded text-sm mb-2">
            ⚠ {{ $ket }}
        </div>
        @endif

        <input type="file" name="bukti_sumbangan" class="form-input w-full"
            {{ disableUpload($dokumen,'bukti_sumbangan') ? 'disabled' : '' }}>
    </div>

    <button class="bg-green-600 text-white px-6 py-2 rounded">
        Upload Dokumen Buku
    </button>
</form>

@elseif($jenis === 'artikel')
<form action="{{ route('dokumen.upload.artikel') }}" method="POST" enctype="multipart/form-data"
    class="bg-white p-6 rounded-lg shadow space-y-5">
    @csrf

    {{-- Pendahuluan --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Pendahuluan
            {!! statusIcon($dokumen,'pendahuluan') !!}
        </label>
        <input type="file" name="pendahuluan" class="form-input w-full"
            {{ disableUpload($dokumen,'pendahuluan') ? 'disabled' : '' }}>
    </div>

    {{-- Artikel Lengkap --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Artikel Lengkap
            {!! statusIcon($dokumen,'artikel_full') !!}
        </label>
        <input type="file" name="artikel_full" class="form-input w-full"
            {{ disableUpload($dokumen,'artikel_full') ? 'disabled' : '' }}>
    </div>

    {{-- Formulir --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Formulir Perpustakaan Terpadu
            {!! statusIcon($dokumen,'surat') !!}
        </label>
        <input type="file" name="surat" class="form-input w-full"
            {{ disableUpload($dokumen,'surat') ? 'disabled' : '' }}>
    </div>

    {{-- Bukti --}}
    <div class="border p-4 rounded">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Bukti Sumbangan Buku
            {!! statusIcon($dokumen,'bukti_sumbangan') !!}
        </label>
        <input type="file" name="bukti_sumbangan" class="form-input w-full"
            {{ disableUpload($dokumen,'bukti_sumbangan') ? 'disabled' : '' }}>
    </div>

    <button class="bg-green-600 text-white px-6 py-2 rounded">
        Upload Dokumen Artikel
    </button>
</form>

@else
<form action="{{ route('dokumen.upload.skripsi') }}" method="POST" enctype="multipart/form-data"
    class="bg-white p-8 rounded-xl shadow space-y-6">
    @csrf

    {{-- PENDAHULUAN --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Pendahuluan
            {!! statusIcon($dokumen, 'pendahuluan') !!}
        </label>
        @if(($ket = keterangan($dokumen, 'pendahuluan')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif
        <div class="text-sm text-gray-700 mb-3">
            <p class="font-semibold mb-1">Pendahuluan mencakup:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>Cover Skripsi</li>
                <li>Kata Pengantar</li>
                <li>Lembar Persetujuan</li>
                <li>Lembar Pengesahan</li>
                <li>Daftar Isi</li>
                <li>Daftar Gambar</li>
                <li>Daftar Lampiran</li>
                <li>Surat Pernyataan, dll</li>
            </ul>
        </div>

        <input type="file" name="pendahuluan"
            class="form-input w-full"
            {{ disableUpload($dokumen, 'pendahuluan') ? 'disabled' : '' }}>
    </div>

    {{-- isi --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-4 text-lg">
            ISI SKRIPSI
        </label>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- BAB I --}}
            <div class="border rounded-md p-3">
                <label class="font-semibold flex items-center gap-2 mb-2">
                    BAB I
                    {!! statusIcon($dokumen, 'bab1') !!}
                </label>
                @if(($ket = keterangan($dokumen, 'bab1')) !== '-')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    ⚠ {{ $ket }}
                </div>
                @endif
                <input type="file" name="bab1"
                    class="form-input w-full"
                    {{ disableUpload($dokumen, 'bab1') ? 'disabled' : '' }}>
            </div>

            {{-- BAB II --}}
            <div class="border rounded-md p-3">
                <label class="font-semibold flex items-center gap-2 mb-2">
                    BAB II
                    {!! statusIcon($dokumen, 'bab2') !!}
                </label>
                @if(($ket = keterangan($dokumen, 'bab2')) !== '-')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    ⚠ {{ $ket }}
                </div>
                @endif
                <input type="file" name="bab2"
                    class="form-input w-full"
                    {{ disableUpload($dokumen, 'bab2') ? 'disabled' : '' }}>
            </div>

            {{-- BAB III --}}
            <div class="border rounded-md p-3">
                <label class="font-semibold flex items-center gap-2 mb-2">
                    BAB III
                    {!! statusIcon($dokumen, 'bab3') !!}
                </label>

                @if(($ket = keterangan($dokumen, 'bab3')) !== '-')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    ⚠ {{ $ket }}
                </div>
                @endif

                <input type="file" name="bab3"
                    class="form-input w-full"
                    {{ disableUpload($dokumen, 'bab3') ? 'disabled' : '' }}>
            </div>

            {{-- BAB IV --}}
            <div class="border rounded-md p-3">
                <label class="font-semibold flex items-center gap-2 mb-2">
                    BAB IV
                    {!! statusIcon($dokumen, 'bab4') !!}
                </label>

                @if(($ket = keterangan($dokumen, 'bab4')) !== '-')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    ⚠ {{ $ket }}
                </div>
                @endif

                <input type="file" name="bab4"
                    class="form-input w-full"
                    {{ disableUpload($dokumen, 'bab4') ? 'disabled' : '' }}>
            </div>

            {{-- BAB V --}}
            <div class="border rounded-md p-3 md:col-span-2">
                <label class="font-semibold flex items-center gap-2 mb-2">
                    BAB V
                    {!! statusIcon($dokumen, 'bab5') !!}
                </label>

                @if(($ket = keterangan($dokumen, 'bab5')) !== '-')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    ⚠ {{ $ket }}
                </div>
                @endif

                <input type="file" name="bab5"
                    class="form-input w-full"
                    {{ disableUpload($dokumen, 'bab5') ? 'disabled' : '' }}>
            </div>
        </div>
    </div>


    {{-- LAMPIRAN --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Lampiran
            {!! statusIcon($dokumen, 'lampiran') !!}
        </label>

        @if(($ket = keterangan($dokumen, 'lampiran')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif

        <div class="text-sm text-gray-700 mb-3">
            Jika lampiran berupa gambar atau data dari suatu program dirubah ke dalam bentuk PDF
        </div>

        <input type="file" name="lampiran" class="form-input w-full"
            {{ disableUpload($dokumen, 'lampiran') ? 'disabled' : '' }}>
    </div>

    {{-- ABSTRAK --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Abstraksi
            {!! statusIcon($dokumen, 'abstraksi') !!}
        </label>

        @if(($ket = keterangan($dokumen, 'abstraksi')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif

        <div class="text-sm text-gray-700 mb-3">
            <ul class="list-disc ml-5 space-y-1">
                <li>Versi Indonesia dan Inggris</li>
                <li>Beri kata kunci</li>
                <li>Tidak discan</li>
            </ul>
        </div>

        <input type="file" name="abstraksi" class="form-input w-full"
            {{ disableUpload($dokumen, 'abstraksi') ? 'disabled' : '' }}>
    </div>

    {{-- JURNAL --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Jurnal
            <span class="bg-yellow-300 text-yellow-900 text-xs font-semibold px-2 py-0.5 rounded">
                Jika Ada
            </span>
            {!! statusIcon($dokumen, 'jurnal') !!}
        </label>

        @if(($ket = keterangan($dokumen, 'jurnal')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif

        <div class="text-sm text-gray-700 mb-3">
            <ul class="list-disc ml-5 space-y-1">
                <li>Jurnal sesuai dengan Fakultas masing-masing</li>
                <li>Minimal 6 halaman, maksimal 10 halaman</li>
            </ul>
        </div>

        <input type="file" name="jurnal" class="form-input w-full"
            {{ disableUpload($dokumen, 'jurnal') ? 'disabled' : '' }}>
    </div>
    {{-- SURAT --}}
    <div class="border rounded-lg p-4">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Scan Formulir Perpustakaan Terpadu
            {!! statusIcon($dokumen, 'surat') !!}
        </label>

        @if(($ket = keterangan($dokumen, 'surat')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif

        <div class="text-sm text-gray-700 mb-3">
            (Surat Pernyataan Persetujuan Publikasi Karya Ilmiah)
            <span class="font-semibold">ATAU</span>
            (Surat Pernyataan Tidak Persetujuan Publikasi Karya Ilmiah)
        </div>
        <input type="file" name="surat" class="form-input w-full"
            {{ disableUpload($dokumen, 'surat') ? 'disabled' : '' }}>
    </div>

    {{-- SKRIPSI LENGKAP --}}
    <div class="border rounded-lg p-4 bg-gray-50">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Skripsi Lengkap (1 File)
            {!! statusIcon($dokumen, 'skripsi_full') !!}
        </label>
        @if(($ket = keterangan($dokumen, 'skripsi_full')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif
        <input type="file" name="skripsi_full" class="form-input w-full"
            {{ disableUpload($dokumen, 'skripsi_full') ? 'disabled' : '' }}>
    </div>

    {{-- Bukti Sumbangan Buku --}}
    <div class="border rounded-lg p-4 bg-gray-50">
        <label class="font-semibold flex items-center gap-2 mb-2">
            Bukti Sumbangan Buku
            {!! statusIcon($dokumen, 'bukti_sumbangan') !!}
        </label>
        @if(($ket = keterangan($dokumen, 'bukti_sumbangan')) !== '-')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
            ⚠ {{ $ket }}
        </div>
        @endif
        <div class="text-sm text-gray-700 mb-3">
            <p class="font-semibold mb-1">Upload Bukti pembayaran sumbangan buku Rp. 100.000,-</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>Bank Kalimantan Tengah</li>
                <li>NoRek : 1000103003211</li>
                <li>an : Universitas Muhammadiyah Palangkaraya</li>
            </ul>
        </div>

        <input type="file" name="bukti_sumbangan" class="form-input w-full"
            {{ disableUpload($dokumen, 'bukti_sumbangan') ? 'disabled' : '' }}>
    </div>

    <button
        class="w-full mt-4 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
        Upload Dokumen
    </button>
</form>

@endif
@endif
@endsection