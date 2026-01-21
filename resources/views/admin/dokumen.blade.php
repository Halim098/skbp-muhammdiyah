@php
$wajibSkripsi = [
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
'bukti_sumbangan' => 'Bukti Sumbangan Buku',
];

$wajibBuku = [
'pendahuluan' => 'Pendahuluan',
'buku_full' => 'Buku Lengkap',
'surat' => 'Scan Formulir Perpustakaan Terpadu',
'bukti_sumbangan' => 'Bukti Sumbangan Buku',
];

$wajibArtikel = [
'pendahuluan' => 'Pendahuluan',
'artikel_full' => 'Artikel Lengkap',
'surat' => 'Scan Formulir Perpustakaan Terpadu',
'bukti_sumbangan' => 'Bukti Sumbangan Buku',
];
@endphp

@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Verifikasi Dokumen Mahasiswa</h1>
<div class="mb-4">
    <form method="GET" class="flex gap-2 items-center">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari NIM, Nama, Fakultas, Prodi..."
            class="w-full md:w-1/3 border px-4 py-2 rounded border-black">

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🔍 Cari
        </button>

        @if(request('q'))
        <a href="{{ route('admin.dokumen.index') }}"
            class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            Reset
        </a>
        @endif
    </form>
</div>


<div class="p-4">
    <table id="dokumenTable" class="w-full border-collapse border">
        <thead class="bg-gray-300">
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">NIM</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Fakultas</th>
                <th class="border p-2">Prodi</th>
                <th class="border p-2">Jenis Karya</th>
                <th class="border p-2">Aksi</th>
                <th class="border p-2">Hapus</th>
            </tr>
        </thead>

        <tbody>
            @php
            $no = ($dokumen->currentPage()-1) * $dokumen->perPage() + 1;
            @endphp

            @foreach($dokumen as $nim => $items)
            <tr>
                <td class="border p-2 text-center">{{ $no++ }}</td>
                <td class="border p-2">{{ $nim }}</td>
                <td class="border p-2">{{ $items->first()->nama }}</td>
                <td class="border p-2">{{ $items->first()->fakultas }}</td>
                <td class="border p-2">{{ $items->first()->jurusan }}</td>
                <td class="border p-2">{{ ucfirst($items->first()->jenis_karya) }}</td>
                <td class="border p-2 text-center">
                    <button onclick="openModal('{{ $nim }}')" class="text-blue-600">
                        🔍
                    </button>
                </td>
                <td class="border p-2 text-center">
                    <form action="{{ route('admin.mahasiswa.destroy', $items->first()->nim) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus mahasiswa {{ $items->first()->nama }} dan semua dokumennya?')">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-600 hover:text-red-800 text-xl">
                            🗑
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $dokumen->links() }}
    </div>
</div>

{{-- ================= MODAL (DI LUAR TABLE) ================= --}}
@foreach($dokumen as $nim => $items)

@php
// 🔑 FIX MASALAH 1: gunakan lowercase
$jenisKarya = strtolower($items->first()->jenis_karya);

$list = match ($jenisKarya) {
'buku' => $wajibBuku,
'artikel' => $wajibArtikel,
default => $wajibSkripsi,
};
@endphp

<div id="modal-{{ $nim }}"
    class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-4xl rounded-lg p-6 relative">

        <button onclick="closeModal('{{ $nim }}')"
            class="absolute top-3 right-3 text-red-600 text-xl">
            ✖
        </button>

        <h2 class="font-bold text-lg mb-4">
            Dokumen {{ $items->first()->nama }} ({{ $nim }})
        </h2>

        <a href="{{ route('admin.dokumen.zip', $nim) }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Download ZIP Semua Dokumen
        </a>

        <form action="{{ route('admin.dokumen.verifikasi.bulk') }}" method="POST">
            @csrf
            <input type="hidden" name="nim" value="{{ $nim }}">

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Jenis</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Lihat</th>
                        <th class="border p-2">Tolak</th>
                        <th class="border p-2">Terima</th>
                        <th class="border p-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($list as $key => $label)
                    @php
                    $doc = $items->firstWhere('jenis', $key);
                    @endphp
                    <tr>
                        <td class="border p-2">{{ $label }}</td>

                        <td class="border p-2">
                            @if(!$doc)
                            <span class="text-gray-400">Belum Upload</span>
                            @elseif($doc->status === 'pending')
                            <span class="text-yellow-600">Pending</span>
                            @elseif($doc->status === 'ditolak')
                            <span class="text-red-600">Ditolak</span>
                            @else
                            <span class="text-green-600">Diterima</span>
                            @endif
                        </td>

                        <td class="border p-2">
                            @if($doc)
                            <a href="{{ route('admin.dokumen.preview',$doc->id) }}"
                                target="_blank" class="text-blue-600">
                                Lihat
                            </a>
                            @endif
                        </td>

                        <td class="border p-2 text-center">
                            @if($doc && in_array($doc->status,['pending','ditolak']))
                            <input type="radio"
                                name="status[{{ $doc->id }}]"
                                value="ditolak">
                            @endif
                        </td>

                        <td class="border p-2 text-center">
                            @if($doc && in_array($doc->status,['pending','ditolak']))
                            <input type="radio"
                                name="status[{{ $doc->id }}]"
                                value="diterima">
                            @endif
                        </td>

                        <td class="border p-2">
                            @if($doc && in_array($doc->status,['pending','ditolak']))
                            <input type="text"
                                name="keterangan[{{ $doc->id }}]"
                                class="border w-full p-1"
                                value="{{ $doc->keterangan }}">
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="text-right mt-4">
                <button class="bg-green-600 text-white px-6 py-2 rounded">
                    Simpan Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    function openModal(nim) {
        document.getElementById('modal-' + nim).classList.remove('hidden');
        document.getElementById('modal-' + nim).classList.add('flex');
    }

    function closeModal(nim) {
        document.getElementById('modal-' + nim).classList.add('hidden');
        document.getElementById('modal-' + nim).classList.remove('flex');
    }
</script>

@endsection