<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index(Request $request)
    {
        // Daftar siswa hanya dapat dibuka melalui kelas tertentu.
        if (!$request->filled('kelas_id')) {
            return redirect()->route('admin.kelas.index');
        }

        $kelasAktif = Kelas::findOrFail($request->kelas_id);

        $murid = Murid::with('kelas')
            ->where('kelas_id', $kelasAktif->id)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('admin.data-murid', compact(
            'murid',
            'kelas',
            'kelasAktif'
        ));
    }

    public function create(Request $request)
    {
        if (!$request->filled('kelas_id')) {
            return redirect()->route('admin.kelas.index');
        }

        $selectedKelas = Kelas::findOrFail($request->kelas_id)->id;
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('admin.tambah-murid', compact(
            'kelas',
            'selectedKelas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:murid,nis',
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        Murid::create($request->only([
            'nis',
            'nama_siswa',
            'kelas_id',
            'jenis_kelamin',
            'tanggal_lahir',
            'nomor_telepon',
        ]));

        return redirect()
            ->route('admin.murid.index', [
                'kelas_id' => $request->kelas_id
            ])
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);

        // Kelas asal digunakan untuk tombol Batal.
        $returnKelasId = $request->query(
            'return_kelas_id',
            $murid->kelas_id
        );

        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('admin.edit-murid', compact(
            'murid',
            'kelas',
            'returnKelasId'
        ));
    }

    public function update(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:20|unique:murid,nis,' . $murid->id,
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        $murid->update($request->only([
            'nis',
            'nama_siswa',
            'kelas_id',
            'jenis_kelamin',
            'tanggal_lahir',
            'nomor_telepon',
        ]));

        // Setelah disimpan, arahkan ke kelas terbaru siswa.
        return redirect()
            ->route('admin.murid.index', [
                'kelas_id' => $murid->kelas_id
            ])
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);
        $kelasId = $murid->kelas_id;

        $murid->delete();

        return redirect()
            ->route('admin.murid.index', [
                'kelas_id' => $kelasId
            ])
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}