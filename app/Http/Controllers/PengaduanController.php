<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\Lampiran;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // =========================
    // DASHBOARD SISWA
    // =========================
    public function dashboard()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        // Ambil semua pengaduan milik siswa yang login
        $riwayat = Pengaduan::where('id_user', Auth::id())
            ->with(['kategori', 'lampiran', 'tanggapan.user'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('dashboard', compact('kategori', 'riwayat'));
    }

    public function dashboardPetugas()
    {
        $pengaduan = Pengaduan::with(['user', 'kategori', 'lampiran', 'tanggapan.user'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('petugas.dashboard', compact('pengaduan'));
    }

    // =========================
    // SIMPAN PENGADUAN
    // =========================
    public function kirim(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $pengaduan = Pengaduan::create([
            'id_user' => Auth::id(),
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'isi_pengaduan' => $request->isi_laporan,
            'status' => 'Menunggu',
        ]);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lampiran'), $filename);

            Lampiran::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'file' => 'uploads/lampiran/' . $filename,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Pengaduan berhasil dikirim!');
    }

    // =========================
    // CARI STATUS BERDASARKAN ID
    // =========================
    public function cari(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        $pengaduan = Pengaduan::where('id_pengaduan', $request->id)
            ->where('id_user', Auth::id())
            ->with(['kategori', 'lampiran', 'tanggapan.user'])
            ->first();

        $riwayat = Pengaduan::where('id_user', Auth::id())
            ->with(['kategori', 'lampiran', 'tanggapan.user'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('dashboard', compact('pengaduan', 'kategori', 'riwayat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Status pengaduan berhasil diperbarui');
    }

    public function kirimTanggapan(Request $request, $id)
    {
        $request->validate([
            'isi_tanggapan' => 'required',
        ]);

        Tanggapan::create([
            'id_pengaduan' => $id,
            'id_user' => Auth::id(),
            'isi_tanggapan' => $request->isi_tanggapan,
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        if ($pengaduan->status == 'Menunggu') {
             $pengaduan->status = 'Diproses';
             $pengaduan->save();
        }

        return back()->with('success', 'Tanggapan berhasil dikirim!');
    }
}
