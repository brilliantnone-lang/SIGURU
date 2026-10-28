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
        $query = Murid::with('kelas');

        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $murid = $query->orderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        
        $kelasAktif = null;
        if ($request->has('kelas_id')) {
            $kelasAktif = Kelas::find($request->kelas_id);
        }

        return view('admin.data-murid', compact('murid', 'kelas', 'kelasAktif'));
    }

    public function create(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $selectedKelas = $request->query('kelas_id');
        
        return view('admin.tambah-murid', compact('kelas', 'selectedKelas'));
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

        Murid::create($request->all());

        // Jika sebelumnya dari halaman kelas, kembalikan ke daftar kelas tersebut
        if ($request->filled('kelas_id')) {
            return redirect()->route('admin.murid.index', ['kelas_id' => $request->kelas_id])
                             ->with('success', 'Data Siswa berhasil ditambahkan!');
        }

        return redirect()->route('admin.murid.index')
                         ->with('success', 'Data Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $murid = Murid::findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('admin.edit-murid', compact('murid', 'kelas'));
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

        $murid->update($request->all());

        return redirect()->route('admin.murid.index', ['kelas_id' => $murid->kelas_id])
                         ->with('success', 'Data Siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);
        $kelas_id = $murid->kelas_id;
        $murid->delete();

        return redirect()->route('admin.murid.index', ['kelas_id' => $kelas_id])
                         ->with('success', 'Data Siswa berhasil dihapus!');
    }
}