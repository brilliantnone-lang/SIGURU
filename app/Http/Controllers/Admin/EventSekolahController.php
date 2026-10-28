<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSekolah;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventSekolahController extends Controller
{
    public function index()
    {
        // Urutkan berdasarkan tanggal terdekat
        $events = EventSekolah::orderBy('tanggal_mulai', 'asc')->get();
        return view('admin.event-sekolah', compact('events'));
    }

    public function create()
    {
        return view('admin.tambah-event');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_rutin' => 'nullable|boolean',
            'hari_rutin' => 'nullable|required_if:is_rutin,1|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal_mulai' => 'nullable|required_if:is_rutin,0|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_full_day' => 'nullable|boolean',
            'jam_mulai_ke' => 'nullable|required_if:is_full_day,0|integer|min:1|max:8',
            'jam_selesai_ke' => 'nullable|required_if:is_full_day,0|integer|min:1|max:8|gte:jam_mulai_ke',
        ]);

        $admin = Admin::where('user_id', Auth::id())->first();
        $isRutin = $request->has('is_rutin');

        EventSekolah::create([
            'nama_event' => $request->nama_event,
            'deskripsi' => $request->deskripsi,
            'is_rutin' => $isRutin,
            'hari_rutin' => $isRutin ? $request->hari_rutin : null,
            'tanggal_mulai' => $isRutin ? null : $request->tanggal_mulai,
            'tanggal_selesai' => $isRutin ? null : $request->tanggal_selesai,
            'is_full_day' => $request->has('is_full_day') ? true : false,
            'jam_mulai_ke' => $request->is_full_day ? null : $request->jam_mulai_ke,
            'jam_selesai_ke' => $request->is_full_day ? null : $request->jam_selesai_ke,
            'admin_id' => $admin->id ?? 1,
        ]);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event Sekolah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = EventSekolah::findOrFail($id);
        return view('admin.edit-event', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = EventSekolah::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_rutin' => 'nullable|boolean',
            'hari_rutin' => 'nullable|required_if:is_rutin,1|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal_mulai' => 'nullable|required_if:is_rutin,0|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_full_day' => 'nullable|boolean',
            'jam_mulai_ke' => 'nullable|required_if:is_full_day,0|integer|min:1|max:8',
            'jam_selesai_ke' => 'nullable|required_if:is_full_day,0|integer|min:1|max:8|gte:jam_mulai_ke',
        ]);

        $isRutin = $request->has('is_rutin');

        $event->update([
            'nama_event' => $request->nama_event,
            'deskripsi' => $request->deskripsi,
            'is_rutin' => $isRutin,
            'hari_rutin' => $isRutin ? $request->hari_rutin : null,
            'tanggal_mulai' => $isRutin ? null : $request->tanggal_mulai,
            'tanggal_selesai' => $isRutin ? null : $request->tanggal_selesai,
            'is_full_day' => $request->has('is_full_day') ? true : false,
            'jam_mulai_ke' => $request->is_full_day ? null : $request->jam_mulai_ke,
            'jam_selesai_ke' => $request->is_full_day ? null : $request->jam_selesai_ke,
        ]);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event Sekolah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = EventSekolah::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.event.index')
            ->with('success', 'Event Sekolah berhasil dihapus!');
    }
}
