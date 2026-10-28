<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        $kalenders = KalenderAkademik::orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'asc')->get();
        return view('admin.kalender', compact('kalenders'));
    }

    public function create()
    {
        return view('admin.tambah-kalender');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_kalender' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        $admin = Admin::where('user_id', Auth::id())->first();

        if ($request->hasFile('file_kalender')) {
            $file = $request->file('file_kalender');
            $namaFile = $file->getClientOriginalName();
            $path = $file->store('kalender', 'public');

            KalenderAkademik::create([
                'admin_id' => $admin->id ?? 1,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nama_file' => $namaFile,
                'path_file' => $path,
            ]);
        }

        return redirect()->route('admin.kalender.index')
                         ->with('success', 'Kalender Akademik berhasil diunggah!');
    }

    public function edit($id)
    {
        $kalender = KalenderAkademik::findOrFail($id);
        return view('admin.edit-kalender', compact('kalender'));
    }

    public function update(Request $request, $id)
    {
        $kalender = KalenderAkademik::findOrFail($id);

        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_kalender' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ];

        if ($request->hasFile('file_kalender')) {
            if ($kalender->path_file && Storage::disk('public')->exists($kalender->path_file)) {
                Storage::disk('public')->delete($kalender->path_file);
            }
            
            $file = $request->file('file_kalender');
            $data['nama_file'] = $file->getClientOriginalName();
            $data['path_file'] = $file->store('kalender', 'public');
        }

        $kalender->update($data);

        return redirect()->route('admin.kalender.index')
                         ->with('success', 'Kalender Akademik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kalender = KalenderAkademik::findOrFail($id);
        
        if ($kalender->path_file && Storage::disk('public')->exists($kalender->path_file)) {
            Storage::disk('public')->delete($kalender->path_file);
        }

        $kalender->delete();

        return redirect()->route('admin.kalender.index')
                         ->with('success', 'Kalender Akademik berhasil dihapus!');
    }
}