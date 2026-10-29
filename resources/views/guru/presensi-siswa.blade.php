@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="presensi-page">

    <div class="presensi-header">
        <h2>Absensi Siswa</h2>
        <p>Catat dan pantau kehadiran siswa pada setiap sesi pembelajaran.</p>
        <div class="presensi-date">
            <i class="bi bi-calendar2-week-fill"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">{{ session('error') }}</div>
    @endif

    @if($message)
        <div style="background:#fff0c9;color:#a86600;padding:15px 20px;border-radius:8px;border:1px solid #ffe4a1;margin-bottom:20px;">
            <i class="bi bi-info-circle"></i> {{ $message }}
        </div>
    @endif

    @if($isSesiPertama)
        <section class="presensi-card">
            <div class="presensi-card-header">
                <i class="bi bi-people-fill"></i>
                <div>
                    <h3>Daftar Siswa Kelas {{ $jadwal->kelas->nama_kelas }}</h3>
                    <p>{{ $murids->count() }} siswa · Jam Ke-{{ $jadwal->jam_mulai_ke }} · {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}</p>
                </div>
            </div>

            <form action="{{ route('guru.presensi-siswa.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

                <div class="presensi-summary">
                    <div class="summary-item summary-hadir"><span>Hadir</span><strong id="count-hadir">0</strong></div>
                    <div class="summary-item summary-sakit"><span>Sakit</span><strong id="count-sakit">0</strong></div>
                    <div class="summary-item summary-izin"><span>Izin</span><strong id="count-izin">0</strong></div>
                    <div class="summary-item summary-alpa"><span>Alpa</span><strong id="count-alpa">0</strong></div>
                </div>

                <div class="table-responsive">
                    <table class="presensi-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Siswa</th>
                                <th>Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($murids as $index => $murid)
                                <tr>
                                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                                    <td class="student-name">{{ $murid->nama_siswa }}</td>
                                    <td>
                                        <div class="attendance-options">
                                            @foreach(['hadir' => 'Hadir', 'sakit' => 'Sakit', 'izin' => 'Izin', 'alpa' => 'Alpa'] as $value => $label)
                                                <button type="button"
                                                    class="attendance-btn {{ (old('absensi.'.$murid->id) ?? ($jurnal && $jurnal->attendances->where('murid_id', $murid->id)->first() && $jurnal->attendances->where('murid_id', $murid->id)->first()->status_kehadiran == $value)) ? 'selected selected-'.$value : '' }}"
                                                    data-status="{{ $value }}"
                                                    onclick="setStatus(this, {{ $murid->id }}, '{{ $value }}')">
                                                    {{ $label }}
                                                </button>
                                            @endforeach
                                            <input type="hidden" name="absensi[{{ $murid->id }}]" id="input-{{ $murid->id }}" value="{{ old('absensi.'.$murid->id) ?? ($jurnal && $jurnal->attendances->where('murid_id', $murid->id)->first() ? $jurnal->attendances->where('murid_id', $murid->id)->first()->status_kehadiran : 'hadir') }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="presensi-footer">
                    <button type="submit" class="btn-simpan-presensi">Simpan Absen</button>
                </div>
            </form>
        </section>
    @endif

</div>

<style>
    /* CSS SAMA PERSIS */
    .presensi-page { width: 100%; color: #222; font-family: inherit; }
    .presensi-header { margin-bottom: 13px; }
    .presensi-header h2 { margin: 0 0 6px; font-size: 26px; font-weight: 650; color: #111; }
    .presensi-header p { margin: 0 0 10px; font-size: 12px; color: #888; }
    .presensi-date { display: inline-flex; align-items: center; gap: 7px; padding: 8px 10px; border: 1px solid #a2d8bf; border-radius: 9px; color: #888; font-size: 11px; }
    .presensi-card { background: #fff; border: 1px solid #b9d0c5; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 3px rgba(0, 0, 0, .15); }
    .presensi-card-header { display: flex; align-items: center; gap: 9px; padding: 10px 12px 7px; }
    .presensi-card-header > i { color: #39765f; font-size: 24px; }
    .presensi-card-header h3 { margin: 0 0 3px; font-size: 18px; font-weight: 650; color: #111; }
    .presensi-card-header p { margin: 0; font-size: 12px; color: #999; }
    .presensi-summary { display: flex; gap: 18px; padding: 2px 7px 6px; }
    .summary-item { display: flex; justify-content: center; align-items: center; gap: 4px; min-width: 76px; padding: 4px 8px; border: 1px solid #d0d0d0; border-radius: 6px; background: #fff; font-size: 11px; }
    .summary-item strong { font-weight: 600; }
    .summary-hadir { color: #39765f; } .summary-sakit { color: #304fbb; } .summary-izin { color: #b78300; } .summary-alpa { color: #777; }
    .table-responsive { width: 100%; overflow-x: auto; }
    .presensi-table { width: 100%; border-collapse: collapse; }
    .presensi-table thead { background: #e1eee8; }
    .presensi-table th { padding: 6px 9px; text-align: left; text-transform: uppercase; font-size: 11px; font-weight: 650; color: #54816c; white-space: nowrap; }
    .presensi-table th:nth-child(3) { text-align: center; }
    .presensi-table td { padding: 7px 9px; border-bottom: 1px solid #e5e5e5; font-size: 11px; vertical-align: middle; }
    .presensi-table tbody tr:last-child td { border-bottom: none; }
    .student-name { font-weight: 500; color: #222; white-space: nowrap; }
    .attendance-options { display: grid; grid-template-columns: repeat(4, minmax(55px, 1fr)); gap: 7px; }
    .attendance-btn { min-height: 22px; padding: 4px 5px; border: 1px solid #ccc; border-radius: 6px; background: #fff; color: #111; font-family: inherit; font-size: 10px; cursor: pointer; transition: background .15s, border-color .15s; }
    .attendance-btn.selected-hadir { background: #dcece5; border-color: #9acbb5; color: #39765f; }
    .attendance-btn.selected-sakit { background: #e5eaff; border-color: #a9b8ef; color: #304fbb; }
    .attendance-btn.selected-izin { background: #fff3d3; border-color: #e5cb79; color: #967000; }
    .attendance-btn.selected-alpa { background: #eeeeee; border-color: #bdbdbd; color: #555; }
    .presensi-footer { display: flex; justify-content: flex-end; margin-top: 15px; padding: 10px; }
    .btn-simpan-presensi { padding: 9px 13px; border: none; border-radius: 6px; background: #39765f; color: #fff; font-family: inherit; font-size: 13px; font-weight: 550; cursor: pointer; }
</style>

<script>
    function setStatus(button, muridId, status) {
        const row = button.closest('tr');
        row.querySelectorAll('.attendance-btn').forEach(btn => {
            btn.classList.remove('selected', 'selected-hadir', 'selected-sakit', 'selected-izin', 'selected-alpa');
        });
        button.classList.add('selected', 'selected-' + status);
        document.getElementById('input-' + muridId).value = status;
        updateSummary();
    }

    function updateSummary() {
        const counts = { hadir: 0, sakit: 0, izin: 0, alpa: 0 };
        document.querySelectorAll('input[name^="absensi["]').forEach(input => {
            if (counts[input.value] !== undefined) counts[input.value]++;
        });
        document.getElementById('count-hadir').textContent = counts.hadir;
        document.getElementById('count-sakit').textContent = counts.sakit;
        document.getElementById('count-izin').textContent = counts.izin;
        document.getElementById('count-alpa').textContent = counts.alpa;
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateSummary();
    });
</script>
@endsection