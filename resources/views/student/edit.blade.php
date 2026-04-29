<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - API Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Student</h2>

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if(session('validation_errors'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Validasi gagal:</strong>
            <ul class="mb-0 mt-1">
                @foreach(session('validation_errors') as $field => $messages)
                    @foreach($messages as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-warning">
            <strong>Form Edit Student</strong>
        </div>
        <div class="card-body">
            <form action="/student/{{ $student['id'] }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim"
                               value="{{ old('nim', $student['nim']) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               value="{{ old('nama', $student['nama']) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="prodi" class="form-label">Prodi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prodi" name="prodi"
                               value="{{ old('prodi', $student['prodi']) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', isset($student['tanggal_lahir']) ? \Carbon\Carbon::parse($student['tanggal_lahir'])->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $student['email']) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat"
                               value="{{ old('alamat', $student['alamat']) }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">💾 Update</button>
                        <a href="/student" class="btn btn-secondary">⬅️ Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
