@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Verifikasi Hardcopy Mahasiswa</h1>

<div class="mb-4">
    <form method="GET" class="mb-4 flex gap-2 items-center">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari NIM, Nama, Fakultas, Prodi, Pilihan..."
            class="w-full md:w-1/3 border px-4 py-2 rounded border-black">

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🔍 Cari
        </button>

        @if(request('q'))
        <a href="{{ route('admin.hardcopy.index') }}"
            class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            Reset
        </a>
        @endif
    </form>
</div>

<div class="p-4">
    <table id="hardcopyTable" class="w-full border-collapse border">
        <thead class="bg-gray-300">
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">NIM</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Fakultas</th>
                <th class="border p-2">Prodi</th>
                <th class="border p-2">Pilihan</th>
                <th class="border p-2">Aksi</th>
                <th class="border p-2">Hapus</th>
            </tr>
        </thead>

        <tbody>
            @php
            $no = ($hardcopy->currentPage()-1) * $hardcopy->perPage() + 1;
            @endphp

            @foreach($hardcopy as $item)
            <tr>
                <td class="border p-2 text-center">{{ $no++ }}</td>
                <td class="border p-2">{{ $item->nim }}</td>
                <td class="border p-2">{{ $item->nama }}</td>
                <td class="border p-2">{{ $item->fakultas }}</td>
                <td class="border p-2">{{ $item->prodi }}</td>
                <td class="border p-2 text-center">
                    {{ $item->pilihan }}
                </td>
                <td class="border p-2 text-center">
                    <form action="{{ route('admin.hardcopy.validasi', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Validasi hardcopy mahasiswa ini?')">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-600 text-white px-3 py-1 rounded">
                            Validasi
                        </button>
                    </form>
                </td>
                <td class="border p-2 text-center">
                    <form action="{{ route('admin.mahasiswa.destroy', $item->nim) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus mahasiswa {{ $item->nama }} dan semua dokumennya?')">
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
        {{ $hardcopy->links() }}
    </div>
</div>
@endsection