<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverJurnal;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoverJurnalController extends Controller
{
    public function index()
    {
        $covers = CoverJurnal::orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();
        return view('admin.data-cover', compact('covers'));
    }

    public function create()
    {
        return view('admin.tambah-cover');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'nama_kepsek' => 'required|string|max:255',
            'nip_kepsek' => 'required|string|max:30',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $admin = Admin::where('user_id', Auth::id())->first();

        $data = $request->all();
        $data['admin_id'] = $admin->id;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logo-sekolah', 'public');
        }

        CoverJurnal::create($data);

        return redirect()->route('admin.data-cover.index')->with('success', 'Cover Jurnal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari data cover secara manual berdasarkan ID
        $cover = CoverJurnal::findOrFail($id);

        // Kirim ke view
        return view('admin.edit-cover', compact('cover'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'nama_kepsek' => 'required|string|max:255',
            'nip_kepsek' => 'required|string|max:30',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $cover = CoverJurnal::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($cover->logo && Storage::disk('public')->exists($cover->logo)) {
                Storage::disk('public')->delete($cover->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo-sekolah', 'public');
        }

        $cover->update($data);

        return redirect()->route('admin.data-cover.index')
            ->with('success', 'Cover Jurnal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID secara manual
        $cover = CoverJurnal::find($id);

        if (!$cover) {
            return redirect()->route('admin.data-cover.index')
                ->with('error', 'Data cover tidak ditemukan!');
        }

        try {
            // Hapus logo jika ada
            if ($cover->logo && Storage::disk('public')->exists($cover->logo)) {
                Storage::disk('public')->delete($cover->logo);
            }

            // Proses hapus
            $cover->delete();

            return redirect()->route('admin.data-cover.index')
                ->with('success', 'Cover Jurnal berhasil dihapus!');
        } catch (\Exception $e) {
            // Jika gagal karena Foreign Key atau error lain, tampilkan pesan aslinya
            return redirect()->route('admin.data-cover.index')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
