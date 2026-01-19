<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .navbar-brand {
            font-weight: 700;
        }
        .card {
            border-radius: 14px;
        }
        .badge {
            font-size: 0.85rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <span class="navbar-brand">Dashboard Petugas</span>

        <form action="{{ route('logout') }}" method="POST" class="d-flex">
            @csrf
            <button class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <h4 class="mb-3">Daftar Pengaduan Masuk</h4>

    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <form action="{{ route('petugas.dashboard') }}" method="GET" class="d-flex align-items-center">
            <label class="me-2">Rekap Bulanan</label>
            <input type="month" name="bulan" class="form-control me-2" value="{{ $bulan ?? '' }}">
            <label class="me-2">Rekap Status</label>
            <select name="status" class="form-select me-2" style="max-width: 180px;">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ ($status ?? '') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ ($status ?? '') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ ($status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button class="btn btn-secondary me-2">Terapkan</button>
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">Reset</a>
        </form>
        <button class="btn btn-outline-primary" onclick="window.print()">Print</button>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- TABEL -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>No. Tiket</th>
                        <th>Judul</th>
                        <th>Pengirim</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Pengaduan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($pengaduan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">#{{ $item->id_pengaduan }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                       
                        <td class="text-center">
                            @if($item->status == 'Menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status == 'Diproses')
                                <span class="badge bg-info">Diproses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>

                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $item->id_pengaduan }}">
                                Detail & Aksi
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada pengaduan masuk
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>

<!-- MODALS -->
@foreach($pengaduan as $item)
<div class="modal fade" id="modal{{ $item->id_pengaduan }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tiket #{{ $item->id_pengaduan }} - {{ $item->judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Pengirim:</strong> {{ $item->user->name }} ({{ $item->user->kelas }})</p>
                        <p><strong>Kategori:</strong> {{ $item->kategori->nama_kategori }}</p>
                        <p><strong>Waktu:</strong> {{ $item->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> {{ $item->status }}</p>
                        <form action="{{ route('pengaduan.updateStatus', $item->id_pengaduan) }}" method="POST" class="d-flex">
                            @csrf
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <button class="btn btn-sm btn-success">Update</button>
                        </form>
                    </div>
                </div>
                
                <hr>
                <h6>Isi Pengaduan:</h6>
                <p class="bg-light p-3 rounded">{{ $item->isi_pengaduan }}</p>

                @if($item->lampiran->count())
                    <h6>Lampiran:</h6>
                    @foreach($item->lampiran as $l)
                        <a href="{{ asset($l->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary mb-2">Lihat File {{ $loop->iteration }}</a>
                    @endforeach
                @endif

                <hr>
                <h6>Riwayat Tanggapan:</h6>
                <div style="max-height: 200px; overflow-y: auto;">
                    @forelse($item->tanggapan as $t)
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <small class="fw-bold">{{ $t->user->name ?? 'Petugas' }}</small>
                                <p class="mb-0">{{ $t->isi_tanggapan }}</p>
                                <small class="text-muted">{{ $t->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada tanggapan.</p>
                    @endforelse
                </div>

                <hr>
                <h6>Kirim Tanggapan:</h6>
                <form action="{{ route('pengaduan.tanggapan', $item->id_pengaduan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea name="isi_tanggapan" class="form-control mb-2" placeholder="Tulis tanggapan..." required></textarea>
                    <div class="mb-2">
                        <label class="form-label">Aksi Foto (opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Unggah foto progres (jpg/png, maks 4MB)</small>
                    </div>
                    <button class="btn btn-primary w-100">Kirim Tanggapan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
@media print {
    .no-print, .navbar, .btn, form { display: none !important; }
    .card, .table { box-shadow: none !important; }
}
</style>

</body>
</html>
