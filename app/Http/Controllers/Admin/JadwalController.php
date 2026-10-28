<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        // Ambil data jadwal beserta relasinya
        $jadwal = Jadwal::with(['guru.user', 'kelas', 'mataPelajaran'])
            ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
            ->orderBy('jam_mulai_ke', 'asc')
            ->get();

        return view('admin.data-pengajaran', compact('jadwal'));
    }

    public function create()
    {
        $guru = Guru::with('user')->get();
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();

        return view('admin.tambah-pengajaran', compact('guru', 'kelas', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai_ke' => 'required|integer|min:1|max:8',
            'jam_selesai_ke' => 'required|integer|min:1|max:8|gte:jam_mulai_ke',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data Pengajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $guru = Guru::with('user')->get();
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();

        return view('admin.edit-pengajaran', compact('jadwal', 'guru', 'kelas', 'mataPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai_ke' => 'required|integer|min:1|max:8',
            'jam_selesai_ke' => 'required|integer|min:1|max:8|gte:jam_mulai_ke',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data Pengajaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data Pengajaran berhasil dihapus!');
    }
}
