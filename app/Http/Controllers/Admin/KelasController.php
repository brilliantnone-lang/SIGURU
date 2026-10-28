<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('admin.data-kelas', compact('kelas'));
    }

    public function create()
    {
        return view('admin.tambah-kelas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'kapasitas' => 'required|integer|min:1|max:100',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Data Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.edit-kelas', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $kelas->id,
            'kapasitas' => 'required|integer|min:1|max:100',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Data Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // Opsional: Cek apakah ada murid di kelas ini sebelum dihapus
        if ($kelas->murid()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                             ->with('error', 'Gagal menghapus! Kelas ini masih memiliki siswa.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Data Kelas berhasil dihapus!');
    }
}