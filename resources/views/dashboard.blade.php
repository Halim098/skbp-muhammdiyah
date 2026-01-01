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
<div class="p-6 bg-white rounded-xl shadow">
    <h2 class="font-bold text-lg mb-4">Tahap 2 — Upload Dokumen</h2>
    <p class="font-semibold mb-2  text-red-700">
        ⚠ Harap melengkapi dokumen dalam waktu 7 hari karena dokumen terhapus otomatis oleh sistem.
    </p>
    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Dokumen</th>
                <th class="border p-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>

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
            'surat' => 'Surat Pernyataan',
            'skripsi_full' => 'Skripsi Lengkap',
            ];
            @endphp

            @foreach($list as $key => $label)
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
                    <span class="text-yellow-500 font-semibold">⏳ Pending</span>
                    @endswitch
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="mt-4">
        <a href="/dokumen"
            class="inline-block bg-green-600 text-white px-4 py-2 rounded">
            Upload Dokumen
        </a>
    </div>
</div>

@endsection