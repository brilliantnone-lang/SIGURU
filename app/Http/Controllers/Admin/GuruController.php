<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan relasi
        $query = Guru::with(['user', 'mataPelajaran']);

        // Filter Mata Pelajaran
        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran);
        }

        // Filter Jenis Kelamin (dari tabel users)
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        $guru = $query->get();
        $mataPelajaran = MataPelajaran::all();

        return view('admin.data-guru', compact('guru', 'mataPelajaran'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::all();
        return view('admin.tambah-guru', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nip_guru' => 'required|string|unique:guru,nip_guru',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        // 1. Buat Akun User
        $user = User::create([
            'name' => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // 2. Buat Profil Guru
        Guru::create([
            'user_id' => $user->id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nip_guru' => $request->nip_guru,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $mataPelajaran = MataPelajaran::all();
        return view('admin.edit-guru', compact('guru', 'mataPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nip_guru' => 'required|string|unique:guru,nip_guru,' . $guru->id,
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        // Update User
        $user->update([
            'name' => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'username' => $request->username,
        ]);

        // Update Password jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update Guru
        $guru->update([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nip_guru' => $request->nip_guru,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus User (karena cascadeOnDelete, data guru juga akan terhapus otomatis)
        $guru->user->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru berhasil dihapus!');
    }
}
