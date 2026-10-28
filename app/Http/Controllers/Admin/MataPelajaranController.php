<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return view('admin.data-mapel', compact('mapel'));
    }

    public function create()
    {
        return view('admin.tambah-mapel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_pelajaran' => 'required|string|max:255|unique:mata_pelajaran,nama_mata_pelajaran',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('admin.mapel.index')
                         ->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        return view('admin.edit-mapel', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $request->validate([
            'nama_mata_pelajaran' => 'required|string|max:255|unique:mata_pelajaran,nama_mata_pelajaran,' . $mapel->id,
        ]);

        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')
                         ->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        
        // Cek apakah mapel dipakai di tabel guru
        if ($mapel->guru()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                             ->with('error', 'Gagal menghapus! Mapel ini sedang dipakai oleh Guru.');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')
                         ->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}