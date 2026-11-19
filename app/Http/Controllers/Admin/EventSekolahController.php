<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSekolah;
use App\Models\Admin;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventSekolahController extends Controller
{
    public function index()
    {
        $events = EventSekolah::with('gurus.user')
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        return view('admin.event-sekolah', compact('events'));
    }

    public function create()
    {
        $gurus = Guru::with('user')->get()->sortBy('user.name');
        return view('admin.tambah-event', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event'       => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'is_rutin'         => 'nullable|boolean',
            'hari_rutin'       => 'nullable|required_if:is_rutin,1|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal_mulai'    => 'nullable|required_if:is_rutin,0|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_full_day'      => 'nullable|boolean',
            'jam_mulai_ke'     => 'nullable|required_if:is_full_day,0|integer|min:1|max:8',
            'jam_selesai_ke'   => 'nullable|required_if:is_full_day,0|integer|min:1|max:8|gte:jam_mulai_ke',
            'is_all_guru'      => 'nullable|boolean',
            'guru_ids'         => 'nullable|array',
            'guru_ids.*'       => 'exists:guru,id',
        ]);

        $admin = Admin::where('user_id', Auth::id())->first();
        $isRutin = $request->has('is_rutin');
        $isAllGuru = $request->has('is_all_guru');

        $event = EventSekolah::create([
            'nama_event'      => $request->nama_event,
            'deskripsi'       => $request->deskripsi,
            'is_rutin'        => $isRutin,
            'hari_rutin'      => $isRutin ? $request->hari_rutin : null,
            'tanggal_mulai'   => $isRutin ? null : $request->tanggal_mulai,
            'tanggal_selesai' => $isRutin ? null : $request->tanggal_selesai,
            'is_full_day'     => $request->has('is_full_day'),
            'jam_mulai_ke'    => $request->has('is_full_day') ? null : $request->jam_mulai_ke,
            'jam_selesai_ke'  => $request->has('is_full_day') ? null : $request->jam_selesai_ke,
            'is_all_guru'     => $isAllGuru,
            'admin_id'        => $admin->id ?? 1,
        ]);

        if (! $isAllGuru && $request->filled('guru_ids')) {
            $event->gurus()->sync($request->guru_ids);
        }

        return redirect()->route('admin.event.create')
            ->with('success', 'Event sekolah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $event = EventSekolah::with('gurus')->findOrFail($id);
        $gurus = Guru::with('user')->get()->sortBy('user.name');
        return view('admin.edit-event', compact('event', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $event = EventSekolah::findOrFail($id);

        $request->validate([
            'nama_event'       => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'is_rutin'         => 'nullable|boolean',
            'hari_rutin'       => 'nullable|required_if:is_rutin,1|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal_mulai'    => 'nullable|required_if:is_rutin,0|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_full_day'      => 'nullable|boolean',
            'jam_mulai_ke'     => 'nullable|required_if:is_full_day,0|integer|min:1|max:8',
            'jam_selesai_ke'   => 'nullable|required_if:is_full_day,0|integer|min:1|max:8|gte:jam_mulai_ke',
            'is_all_guru'      => 'nullable|boolean',
            'guru_ids'         => 'nullable|array',
            'guru_ids.*'       => 'exists:guru,id',
        ]);

        $isRutin = $request->has('is_rutin');
        $isAllGuru = $request->has('is_all_guru');

        $event->update([
            'nama_event'      => $request->nama_event,
            'deskripsi'       => $request->deskripsi,
            'is_rutin'        => $isRutin,
            'hari_rutin'      => $isRutin ? $request->hari_rutin : null,
            'tanggal_mulai'   => $isRutin ? null : $request->tanggal_mulai,
            'tanggal_selesai' => $isRutin ? null : $request->tanggal_selesai,
            'is_full_day'     => $request->has('is_full_day'),
            'jam_mulai_ke'    => $request->has('is_full_day') ? null : $request->jam_mulai_ke,
            'jam_selesai_ke'  => $request->has('is_full_day') ? null : $request->jam_selesai_ke,
            'is_all_guru'     => $isAllGuru,
        ]);

        if ($isAllGuru) {
            $event->gurus()->detach();
        } else {
            $event->gurus()->sync($request->guru_ids ?? []);
        }

        return redirect()->route('admin.event.index')
            ->with('success', 'Event sekolah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = EventSekolah::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.event.index')
            ->with('success', 'Event Sekolah berhasil dihapus!');
    }
}