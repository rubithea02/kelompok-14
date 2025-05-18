<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        table th, table td {
            vertical-align: middle !important;
        }
        footer {
            margin-top: 40px;
            padding: 15px 0;
            background-color: #0d6efd;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/gudang') }}">GUDANG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <main class="container my-5">
        <h1 class="mb-4 text-primary">INPUT KODE CABANG</h1>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row gy-4">
            <!-- Form input -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        {{ isset($edit) ? 'Edit Data Gudang' : 'Tambah Data Cabang' }}
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($edit) ? url('/gudang/'.$edit->kd_gudang) : url('/gudang') }}" method="POST" novalidate>
                            @csrf
                            @if(isset($edit))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="kd_gudang" class="form-label">Kode Cabang</label>
                                <input type="text" id="kd_gudang" name="kd_gudang" class="form-control @error('kd_gudang') is-invalid @enderror"
                                    value="{{ old('kd_gudang', $edit->kd_gudang ?? '') }}" {{ isset($edit) ? 'readonly' : '' }} maxlength="4" required>
                                @error('kd_gudang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_gudang" class="form-label">Nama Cabang</label>
                                <input type="text" id="nama_gudang" name="nama_gudang" class="form-control @error('nama_gudang') is-invalid @enderror"
                                    value="{{ old('nama_gudang', $edit->nama_gudang ?? '') }}" maxlength="45" required>
                                @error('nama_gudang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat_gudang" class="form-label">Alamat Cabang</label>
                                <input type="text" id="alamat_gudang" name="alamat_gudang" class="form-control @error('alamat_gudang') is-invalid @enderror"
                                    value="{{ old('alamat_gudang', $edit->alamat_gudang ?? '') }}" maxlength="45" required>
                                @error('alamat_gudang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="koordinat" class="form-label">Koordinat</label>
                                <div class="d-flex">
                                    <input type="text" id="koordinat" name="koordinat" class="form-control me-2 @error('koordinat') is-invalid @enderror"
                                        value="{{ old('koordinat', $edit->koordinat ?? '') }}" maxlength="45" required readonly>
                                    <button type="button" class="btn btn-outline-primary" onclick="getLocation()" title="Ambil Lokasi">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </button>
                                </div>
                                @error('koordinat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($edit) ? 'Update Data' : 'Tambah Data' }}
                                </button>
                                @if(isset($edit))
                                    <a href="{{ url('/gudang') }}" class="btn btn-outline-secondary">Batal</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel data -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Data Cabang
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Kode Cabang</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Koordinat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gudangs as $gudang)
                                        <tr>
                                            <td>{{ $gudang->kd_gudang }}</td>
                                            <td>{{ $gudang->nama_gudang }}</td>
                                            <td>{{ $gudang->alamat_gudang }}</td>
                                            <td>{{ $gudang->koordinat }}</td>
                                            <td class="d-flex gap-2">
                                                <a href="{{ url('/gudang/'.$gudang->kd_gudang.'/edit') }}" class="btn btn-sm btn-warning d-flex align-items-center justify-content-center" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ url('/gudang/'.$gudang->kd_gudang) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Data  kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Batasi input hanya 4 karakter
        document.getElementById('kd_gudang').addEventListener('input', function () {
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        });

        // Ambil lokasi pengguna
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('koordinat').value =
                        position.coords.latitude + ',' + position.coords.longitude;
                }, function () {
                    alert('Gagal mendapatkan lokasi. Pastikan Anda mengizinkan akses lokasi.');
                });
            } else {
                alert("Browser tidak mendukung geolokasi.");
            }
        }
    </script>
</body>
</html>
