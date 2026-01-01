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


function disableUpload($dokumen, $key) {
if (!isset($dokumen[$key])) return false;
return in_array($dokumen[$key]->status, ['pending', 'diterima']);
}
@endphp


@extends('layouts.app')

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
<form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data"
    class="bg-white p-8 rounded-xl shadow">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PENDAHULUAN --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Pendahuluan
                {!! statusIcon($dokumen, 'pendahuluan') !!}
            </label>
            <input type="file" name="pendahuluan" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'pendahuluan') ? 'disabled' : '' }}>
        </div>

        {{-- ISI BAB I --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                ISI – BAB I
                {!! statusIcon($dokumen, 'bab1') !!}
            </label>
            <input type="file" name="bab1" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'bab1') ? 'disabled' : '' }}>
        </div>

        {{-- ISI BAB II --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                ISI – BAB II
                {!! statusIcon($dokumen, 'bab2') !!}
            </label>
            <input type="file" name="bab2" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'bab2') ? 'disabled' : '' }}>
        </div>

        {{-- ISI BAB III --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                ISI – BAB III
                {!! statusIcon($dokumen, 'bab3') !!}
            </label>
            <input type="file" name="bab3" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'bab3') ? 'disabled' : '' }}>
        </div>

        {{-- ISI BAB IV --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                ISI – BAB IV
                {!! statusIcon($dokumen, 'bab4') !!}
            </label>
            <input type="file" name="bab4" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'bab4') ? 'disabled' : '' }}>
        </div>

        {{-- ISI BAB V --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                ISI – BAB V
                {!! statusIcon($dokumen, 'bab5') !!}
            </label>
            <input type="file" name="bab5" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'bab5') ? 'disabled' : '' }}>
        </div>

        {{-- LAMPIRAN --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Lampiran
                {!! statusIcon($dokumen, 'lampiran') !!}
            </label>
            <input type="file" name="lampiran" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'lampiran') ? 'disabled' : '' }}>
        </div>

        {{-- ABSTRAK --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Abstraksi
                {!! statusIcon($dokumen, 'abstraksi') !!}
            </label>
            <input type="file" name="abstraksi" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'abstraksi') ? 'disabled' : '' }}>
        </div>

        {{-- JURNAL --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Jurnal
                {!! statusIcon($dokumen, 'jurnal') !!}
            </label>
            <input type="file" name="jurnal" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'jurnal') ? 'disabled' : '' }}>
        </div>

        {{-- SURAT PERNYATAAN --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Scan Surat Pernyataan
                {!! statusIcon($dokumen, 'surat') !!}
            </label>
            <input type="file" name="surat" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'surat') ? 'disabled' : '' }}>
        </div>

        {{-- SKRIPSI LENGKAP --}}
        <div class="md:col-span-2">
            <label class="font-semibold flex items-center gap-2">
                Skripsi Lengkap (1 File)
                {!! statusIcon($dokumen, 'skripsi_full') !!}
            </label>
            <input type="file" name="skripsi_full" class="form-input mt-1 w-full" {{ disableUpload($dokumen, 'skripsi_full') ? 'disabled' : '' }}>
        </div>
    </div>

    <button class="mt-6 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
        Upload Dokumen
    </button>
</form>
@endif
@endsection