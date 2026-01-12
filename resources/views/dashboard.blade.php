<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
        }

        .header-title {
            font-weight: 700;
            color: #1a2b4c;
        }

        .card-custom {
            border-radius: 12px;
            border: none;
        }

        .section-title {
            font-weight: 600;
            font-size: 18px;
        }

        .nav-brand-custom {
            font-weight: 700;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <span class="navbar-brand nav-brand-custom">Sistem Pengaduan Siswa</span>

            <div class="d-flex">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <div class="container mt-4">
        <h2 class="header-title">Sampaikan Pengaduanmu Disini</h2>
        <p class="text-muted">Mudah, Cepat, dan Aman</p>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mt-3">
        <div class="row g-4">

            <!-- FORM PENGADUAN -->
            <div class="col-lg-7">
                <div class="card card-custom p-4 shadow-sm">
                    <h5 class="section-title mb-3">Form Pengaduan Siswa</h5>

                    <form action="{{ route('pengaduan.kirim') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>NIS</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->nis }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Kelas</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->kelas }}" disabled>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Judul Pengaduan</label>
                                <input type="text" name="judul" class="form-control" placeholder="Contoh: AC Kelas Rusak" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Pilih Kategori</label>
                                <select name="id_kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @forelse($kategori as $item)
                                        <option value="{{ $item->id_kategori }}">
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @empty
                                        <option disabled>Kategori belum tersedia</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pengaduan</label>
                            <textarea name="isi_laporan" class="form-control" rows="4" placeholder="Jelaskan pengaduanmu..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Unggah Lampiran (opsional)</label>
                            <input type="file" name="lampiran" class="form-control">
                            <small class="text-muted">Maks. ukuran: 5MB (jpg, png, pdf)</small>
                        </div>

                        <button class="btn btn-primary w-100 fw-bold">KIRIM PENGADUAN</button>
                    </form>
                </div>
            </div>

            <!-- STATUS PENGADUAN -->
            <div class="col-lg-5">
                <div class="card card-custom p-4 shadow-sm">
                    <h5 class="section-title mb-3">Status Pengaduan Terkini</h5>

                    <form action="{{ route('pengaduan.cari') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="id" class="form-control me-2" placeholder="Masukkan No. Tiket">
                        <button class="btn btn-success">Cari</button>
                    </form>

                    @isset($pengaduan)
                        <div class="p-3 bg-light rounded">
                            <p><strong>No. Tiket:</strong> #{{ $pengaduan->id_pengaduan }}</p>
                            <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge bg-info">{{ $pengaduan->status }}</span>
                            </p>
                            
                            @if($pengaduan->lampiran->count())
                                <p><strong>Lampiran:</strong> 
                                    @foreach($pengaduan->lampiran as $l)
                                        <a href="{{ asset($l->file) }}" target="_blank">Lihat File</a>
                                    @endforeach
                                </p>
                            @endif

                            <strong>Tanggapan:</strong>
                            @forelse($pengaduan->tanggapan as $t)
                                <div class="alert alert-info p-2 mt-2">
                                    <strong>{{ $t->user->name ?? 'Petugas' }} (Petugas):</strong>
                                    <p class="mb-0">{{ $t->isi_tanggapan }}</p>
                                    <small class="text-muted">{{ $t->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada tanggapan.</p>
                            @endforelse
                        </div>
                    @else
                        <p class="text-muted">Masukkan nomor tiket untuk melihat status pengaduan Anda.</p>
                    @endisset
                </div>
            </div>

            <!-- RIWAYAT PENGADUAN -->
            <div class="card card-custom p-4 shadow-sm mt-4">
                <h5 class="section-title mb-3">Riwayat Pengaduan Saya</h5>

                @if ($riwayat->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No Tiket</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $item)
                                    <tr>
                                        <td>#{{ $item->id_pengaduan }}</td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                    @if ($item->status == 'Menunggu') bg-warning
                                    @elseif($item->status == 'Diproses') bg-info
                                    @else bg-success @endif
                                ">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->tanggapan->count())
                                                <span class="badge bg-primary">{{ $item->tanggapan->count() }} Balasan</span>
                                                <br>
                                                <small><a href="{{ route('pengaduan.cari', ['id' => $item->id_pengaduan]) }}">Lihat</a></small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada pengaduan.</p>
                @endif
            </div>
        </div>
    </div>

</body>

</html>
