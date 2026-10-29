<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ModulAjar;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BahanAjarController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        if (!$guru) return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');

        $bahanAjar = ModulAjar::with('kelas')
            ->where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.bahan-ajar', compact('bahanAjar'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('guru.unggah-bahan-ajar', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'file_bahan_ajar' => 'required|mimes:pdf,doc,docx|max:3072',
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        if (!$guru) return redirect()->back()->with('error', 'Data guru tidak ditemukan.');

        if ($request->hasFile('file_bahan_ajar')) {
            $file = $request->file('file_bahan_ajar');
            $namaFile = $request->judul_materi . ' - ' . $file->getClientOriginalName();
            $path = $file->store('bahan-ajar', 'public');

            ModulAjar::create([
                'guru_id' => $guru->id,
                'kelas_id' => $request->kelas_id,
                'nama_file' => $namaFile,
                'path_file' => $path,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('guru.bahan-ajar')
            ->with('success', 'Bahan ajar berhasil diunggah!');
    }

    public function edit($id)
    {
        $bahanAjar = ModulAjar::findOrFail($id);
        $guru = Guru::where('user_id', Auth::id())->first();
        if ($bahanAjar->guru_id !== $guru->id) abort(403, 'Anda tidak berhak mengedit bahan ajar ini.');

        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('guru.edit-bahan-ajar', compact('bahanAjar', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $bahanAjar = ModulAjar::findOrFail($id);
        $guru = Guru::where('user_id', Auth::id())->first();
        if ($bahanAjar->guru_id !== $guru->id) abort(403);

        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'file_bahan_ajar' => 'nullable|mimes:pdf,doc,docx|max:3072',
        ]);

        $namaFile = $bahanAjar->nama_file;
        $path = $bahanAjar->path_file;

        if ($request->hasFile('file_bahan_ajar')) {
            if ($bahanAjar->path_file && Storage::disk('public')->exists($bahanAjar->path_file)) {
                Storage::disk('public')->delete($bahanAjar->path_file);
            }
            $file = $request->file('file_bahan_ajar');
            $namaFile = $request->judul_materi . ' - ' . $file->getClientOriginalName();
            $path = $file->store('bahan-ajar', 'public');
        }

        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'catatan' => 'nullable|string',
            'file_bahan_ajar' => 'nullable|mimes:pdf,doc,docx|max:3072',
        ]);

        // ... di dalam proses update ...
        $bahanAjar->update([
            'kelas_id' => $request->kelas_id,
            'nama_file' => $namaFile,
            'path_file' => $path,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.bahan-ajar')
            ->with('success', 'Bahan ajar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bahanAjar = ModulAjar::findOrFail($id);
        $guru = Guru::where('user_id', Auth::id())->first();
        if ($bahanAjar->guru_id !== $guru->id) abort(403);

        if ($bahanAjar->path_file && Storage::disk('public')->exists($bahanAjar->path_file)) {
            Storage::disk('public')->delete($bahanAjar->path_file);
        }

        $bahanAjar->delete();

        return redirect()->route('guru.bahan-ajar')
            ->with('success', 'Bahan ajar berhasil dihapus!');
    }
}
