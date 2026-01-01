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
            <input type="text" name="fakultas"
                placeholder="{{ $mhs->fakultas }}"
                class="w-full px-4 py-3 border rounded">

            <p>Jurusan :</p>
            <input type="text" name="jurusan"
                placeholder="{{ $mhs->jurusan }}"
                class="w-full px-4 py-3 border rounded">

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

            </select>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-8 text-center">
        <button
            class="bg-green-600 text-white px-10 py-3 rounded-lg hover:bg-green-700">
            Simpan Perubahan
        </button>
    </div>

</form>
@endsection