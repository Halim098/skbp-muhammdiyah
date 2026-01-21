@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Daftar Mahasiswa Valid SKBP</h1>

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
        <a href="{{ route('admin.skbp.index') }}"
            class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            Reset
        </a>
        @endif
    </form>
</div>

<div class="p-4">
    <table class="w-full border-collapse border text-sm">
        <thead class="bg-gray-300">
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">NIM</th>
                <th class="border p-2">Fakultas</th>
                <th class="border p-2">Program Studi</th>
                <th class="border p-2">Alamat</th>
                <th class="border p-2">Softcopy</th>
                <th class="border p-2">Hardcopy</th>
                <th class="border p-2">Judul</th>
                <th class="border p-2">Aksi</th>
                <th class="border p-2">Hapus</th>
            </tr>
        </thead>

        <tbody>
            @php
            $no = ($skbp->currentPage()-1) * $skbp->perPage() + 1;
            @endphp

            @foreach($skbp as $item)
            <tr>
                <td class="border p-2 text-center">{{ $no++ }}</td>
                <td class="border p-2">{{ $item->nama }}</td>
                <td class="border p-2">{{ $item->nim }}</td>
                <td class="border p-2">{{ $item->fakultas }}</td>
                <td class="border p-2">{{ $item->prodi }}</td>
                <td class="border p-2">{{ $item->alamat }}</td>

                {{-- STATUS SOFTCOPY --}}
                <td class="border p-2 text-center">
                    @if($item->status_dokumen === 'valid')
                    <span class="text-green-600 font-semibold">✔ Valid</span>
                    @else
                    <span class="text-red-600 font-semibold">✖ Tidak Valid</span>
                    @endif
                </td>

                {{-- STATUS HARDCOPY --}}
                <td class="border p-2 text-center">
                    @if($item->status_hardcopy === 'valid')
                    <span class="text-green-600 font-semibold">✔ Valid</span>
                    @else
                    <span class="text-red-600 font-semibold">✖ Tidak Valid</span>
                    @endif
                </td>

                <td class="border p-2">{{ $item->judul_karya }}</td>

                <td class="border p-2 text-center">
                    <a href="{{ route('admin.skbp.cetak', $item->nim) }}"
                        target="_blank"
                        class="bg-green-600 text-white px-3 py-1 rounded">
                        🖨
                    </a>
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
        {{ $skbp->links() }}
    </div>
</div>
@endsection