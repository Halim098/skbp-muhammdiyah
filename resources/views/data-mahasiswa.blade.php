@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Data Mahasiswa</h1>

@php
$mhs = session('mahasiswa');
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
                class="w-full px-4 py-3 border rounded bg-gray-100">

            <p>Nama :</p>
            <input type="text" name="nama"
                placeholder="{{ $mhs->nama }}"
                class="w-full px-4 py-3 border rounded">

            <p>Fakultas :</p>
            <select name="fakultas"
                class="w-full px-4 py-3 border rounded select-search">
                <option value="">-- Pilih Fakultas --</option>
                @foreach($fakultas as $f)
                <option value="{{ $f->nama }}"
                    {{ ($mhs->fakultas ?? '') == $f->nama ? 'selected' : '' }}>
                    {{ $f->nama }}
                </option>
                @endforeach
            </select>

            <p>Prodi :</p>
            <select name="jurusan"
                class="w-full px-4 py-3 border rounded select-search">
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodi as $p)
                <option value="{{ $p->nama }}"
                    {{ ($mhs->jurusan ?? '') == $p->nama ? 'selected' : '' }}>
                    {{ $p->nama }}
                </option>
                @endforeach
            </select>

            <p>Alamat :</p>
            <input type="text" name="alamat"
                placeholder="{{ $mhs->alamat ?? 'Alamat' }}"
                class="w-full px-4 py-3 border rounded">

        </div>

        <!-- KANAN -->
        <div class="space-y-4">
            <p>Tempat, Tanggal Lahir :</p>
            <input type="text" name="tempat_tanggal_lahir"
                placeholder="{{ $mhs->tempat_tanggal_lahir ?? 'Tempat, Tanggal Lahir' }}"
                class="w-full px-4 py-3 border rounded">

            <p>No HP :</p>
            <input type="text" name="no_hp"
                placeholder="{{ $mhs->no_hp ?? 'No HP' }}"
                class="w-full px-4 py-3 border rounded">

            <p>Email :</p>
            <input type="email" name="email"
                placeholder="{{ $mhs->email ?? 'Email' }}"
                class="w-full px-4 py-3 border rounded">

            <p>Agama :</p>
            <select name="agama"
                class="w-full px-4 py-3 border rounded">
                <option value="" disabled selected>Agama</option>
                <option {{ ($mhs->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option {{ ($mhs->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option {{ ($mhs->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option {{ ($mhs->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option {{ ($mhs->agama ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>

            <p>Jenis Karya :</p>
            <select name="jenis"
                class="w-full px-4 py-3 border rounded">
                <option value="" disabled selected>Jenis Karya</option>
                <option value="skripsi" {{ ($mhs->jenis ?? '') == 'skripsi' ? 'selected' : '' }}>Skripsi</option>
                <option value="KTI" {{ ($mhs->jenis ?? '') == 'KTI' ? 'selected' : '' }}>KTI</option>
                <option value="tesis" {{ ($mhs->jenis ?? '') == 'tesis' ? 'selected' : '' }}>Tesis</option>
                <option value="artikel" {{ ($mhs->jenis ?? '') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                <option value="buku" {{ ($mhs->jenis ?? '') == 'buku' ? 'selected' : '' }}>Buku</option>
            </select>
        </div>
    </div>
    <p class="mt-3 mb-2">Judul Karya Ilmiah :</p>
    <input type="text" name="judul_karya"
        placeholder="{{ $mhs->judul_karya ?? 'Judul Karya' }}"
        class="w-full px-4 py-3 border rounded">

    <!-- BUTTON -->
    <div class="mt-8 text-center">
        <button
            class="bg-green-600 text-white px-10 py-3 rounded-lg hover:bg-green-700">
            Simpan Perubahan
        </button>
    </div>

</form>
@endsection