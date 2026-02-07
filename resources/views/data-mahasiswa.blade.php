@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Data Mahasiswa</h1>

@php
$mhs = session('mahasiswa');

function fieldValue($val) {
return ($val && $val !== '-') ? $val : '';
}
@endphp

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="/mahasiswa/update"
    class="bg-white p-8 rounded-xl shadow">

    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- KIRI -->
        <div class="space-y-4">
            <p>NIM :</p>
            <input type="text" name="nim" readonly
                value="{{ $mhs->nim }}"
                class="w-full px-4 py-3 border rounded bg-gray-100"
                required>

            <p>Nama :</p>
            <input type="text" name="nama"
                value="{{ fieldValue($mhs->nama) }}"
                class="w-full px-4 py-3 border rounded"
                required>


            <p>Fakultas :</p>
            <select name="fakultas" required
                class="w-full px-4 py-3 border rounded select-search">
                <option value="">-- Pilih Fakultas --</option>
                @foreach($fakultas as $f)
                <option value="{{ $f->nama }}"
                    {{ strtolower($mhs->fakultas ?? '') == strtolower($f->nama) ? 'selected' : '' }}>
                    {{ $f->nama }}
                </option>
                @endforeach
            </select>

            <p>Prodi :</p>
            <select name="jurusan" required
                class="w-full px-4 py-3 border rounded select-search">
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodi as $p)
                <option value="{{ $p->nama }}"
                    {{ strtolower($mhs->jurusan ?? '') == strtolower($p->nama) ? 'selected' : '' }}>
                    {{ $p->nama }}
                </option>
                @endforeach
            </select>

            <p>Alamat :</p>
            <input type="text" name="alamat"
                value="{{ fieldValue($mhs->alamat) }}"
                class="w-full px-4 py-3 border rounded"
                required>


        </div>

        <!-- KANAN -->
        <div class="space-y-4">
            <p>Tempat, Tanggal Lahir :</p>
            <input type="text" name="tempat_tanggal_lahir"
                value="{{ fieldValue($mhs->tempat_tanggal_lahir) }}"
                class="w-full px-4 py-3 border rounded"
                required>

            <p>No HP :</p>
            <input type="text" name="no_hp"
                value="{{ fieldValue($mhs->no_hp) }}"
                class="w-full px-4 py-3 border rounded"
                required>

            <p>Email :</p>
            <input type="email" name="email"
                value="{{ fieldValue($mhs->email) }}"
                class="w-full px-4 py-3 border rounded"
                required>


            <p>Agama :</p>
            <select name="agama" required
                class="w-full px-4 py-3 border rounded">
                <option value="" disabled selected>Agama</option>
                <option {{ ($mhs->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option {{ ($mhs->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option {{ ($mhs->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option {{ ($mhs->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option {{ ($mhs->agama ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>

            <p>Jenis Karya :</p>
            <select name="jenis" required
                class="w-full px-4 py-3 border rounded">
                <option value="" disabled selected>Jenis Karya</option>
                <option value="Skripsi" {{ strtolower($mhs->jenis ?? '') == 'skripsi' ? 'selected' : '' }}>Skripsi</option>
                <option value="KTI" {{ strtolower($mhs->jenis ?? '') == 'kti' ? 'selected' : '' }}>KTI</option>
                <option value="Tesis" {{ strtolower($mhs->jenis ?? '') == 'tesis' ? 'selected' : '' }}>Tesis</option>
                <option value="Artikel" {{ strtolower($mhs->jenis ?? '') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                <option value="Buku" {{ strtolower($mhs->jenis ?? '') == 'buku' ? 'selected' : '' }}>Buku</option>
            </select>
        </div>
    </div>

    <p class="mt-3 mb-2">Judul Karya Ilmiah :</p>
    <input type="text" name="judul_karya"
        value="{{ fieldValue($mhs->judul_karya) }}"
        class="w-full px-4 py-3 border rounded"
        required>


    <!-- BUTTON -->
    <div class="mt-8 text-center">
        <button
            class="bg-green-600 text-white px-10 py-3 rounded-lg hover:bg-green-700">
            Simpan Perubahan
        </button>
    </div>

</form>
@endsection