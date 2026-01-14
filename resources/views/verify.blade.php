<head>
    <meta charset="UTF-8">
    <title>Verifikasi SKBP</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center fw-bold">
                    🔍 Verifikasi SKBP
                </div>

                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold">Nama</td>
                            <td>:</td>
                            <td>{{ $data->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">NIM</td>
                            <td>:</td>
                            <td>{{ $data->nim ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Judul</td>
                            <td>:</td>
                            <td>{{ $data->judul_karya ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dokumen</td>
                            <td>:</td>
                            <td>
                                <span class="badge 
                                    {{ ($data->status_dokumen ?? '-') === 'valid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($data->status_dokumen ?? '-') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Hardcopy</td>
                            <td>:</td>
                            <td>
                                <span class="badge 
                                    {{ ($data->hardcopy ?? '-') === 'valid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($data->hardcopy ?? '-') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">SKBP</td>
                            <td>:</td>
                            <td>
                                <span class="badge 
                                    {{ ($data->status_skbp ?? '-') === 'valid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($data->status_skbp ?? '-') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="card-footer text-center">
                    @if(($data->status_skbp ?? '-') === 'valid')
                    <span class="text-success fw-bold">✅ SKBP Sah & Terverifikasi</span>
                    @else
                    <span class="text-danger fw-bold">❌ SKBP Tidak Valid</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>