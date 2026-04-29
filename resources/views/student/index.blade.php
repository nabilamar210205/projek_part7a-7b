<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Student - API Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">📚 Data Student — API Client</h2>

    {{-- Alert Success --}}
    @if(session('success') || isset($success))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') ?? $success }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error') || isset($error))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') ?? $error }}
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

    {{-- Form Tambah Student --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>➕ Tambah Student</strong>
        </div>
        <div class="card-body">
            <form action="/student" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="prodi" class="form-label">Prodi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prodi" name="prodi" value="{{ old('prodi') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data Student --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            <strong>📋 Daftar Student</strong>
            @if(isset($pagination['total']))
                <span class="badge bg-light text-dark float-end">Total: {{ $pagination['total'] }} data</span>
            @endif
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        <tr>
                            {{-- Nomor urut berlanjut berdasarkan 'from' pagination --}}
                            <td>{{ ($pagination['from'] ?? 1) + $index }}</td>
                            <td>{{ $student['nim'] }}</td>
                            <td>{{ $student['nama'] }}</td>
                            <td>{{ $student['prodi'] }}</td>
                            <td>{{ isset($student['tanggal_lahir']) ? \Carbon\Carbon::parse($student['tanggal_lahir'])->format('Y-m-d') : '-' }}</td>
                            <td>{{ $student['email'] ?? '-' }}</td>
                            <td>{{ $student['alamat'] ?? '-' }}</td>
                            <td>
                                <a href="/student/{{ $student['id'] }}/edit" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <form action="/student/{{ $student['id'] }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Belum ada data student.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($links) && count($links) > 3)
            <div class="card-footer">
                <nav>
                    <ul class="pagination justify-content-center mb-0">
                        @foreach($links as $link)
                            <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $link['url'] ?? '#' }}">{!! $link['label'] !!}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <p class="text-center text-muted mt-2 mb-0">
                    Halaman {{ $pagination['current_page'] ?? '-' }} dari {{ $pagination['last_page'] ?? '-' }}
                </p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
