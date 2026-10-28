@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi - SIGURU')

@section('content')
<div class="admin-rekap">

    <div class="rekap-heading">
        <h1>Rekapitulasi Absensi Siswa</h1>
        <p>Data kehadiran siswa berdasarkan filter yang dipilih</p>
    </div>

    {{-- Filter --}}
    <form action="{{ route('kepsek.rekapitulasi-absensi.index') }}" method="GET" class="rekap-filter">
        <div class="filter-field">
            <label for="filter-tanggal">Tanggal (Opsional)</label>
            <input type="date" id="filter-tanggal" name="tanggal" value="{{ $tanggal }}">
        </div>

        <div class="filter-field">
            <label for="filter-kelas">Kelas (Opsional)</label>
            <select id="filter-kelas" name="kelas_id">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="filter-field">
            <label for="filter-status">Status Kehadiran (Opsional)</label>
            <select id="filter-status" name="status">
                <option value="">Semua Status</option>
                <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}>Alpa</option>
            </select>
        </div>

        <button type="submit" class="bahan-filter-button">
            <i class="bi bi-search"></i> Tampilkan
        </button>
    </form>

    {{-- Tabel rekap --}}
    <section class="rekap-table-panel">
        <div class="rekap-table-heading">
            <span aria-hidden="true">♟</span>
            <h2>
                @if($mode == 'detail_siswa')
                Daftar Siswa Kelas {{ $kelas->find($kelasId)->nama_kelas ?? '' }}
                @if($tanggal) ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}) @endif
                @if($status) - Status: {{ ucfirst($status) }} @endif
                @else
                Rekapitulasi Kehadiran Siswa
                @endif
            </h2>
        </div>

        <div class="rekap-table-scroll">
            <table class="rekap-table">
                <thead>
                    {{-- LOGIKA HEADER TABEL DINAMIS --}}
                    @if($mode == 'detail_siswa')
                    <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        @if(!$tanggal)
                        <th>Tanggal</th>
                        @endif
                        <th>Status Kehadiran</th>
                    </tr>
                    @elseif($tanggal && !$kelasId)
                    <tr>
                        <th>No.</th>
                        <th>Kelas</th>
                        <th>Total Siswa</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpa</th>
                        <th>Aksi</th>
                    </tr>
                    @elseif(!$tanggal && $kelasId)
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Total Presensi</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpa</th>
                        <th>Aksi</th>
                    </tr>
                    @elseif(!$tanggal && !$kelasId && $status)
                    <tr>
                        <th>No.</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jumlah Siswa ({{ ucfirst($status) }})</th>
                    </tr>
                    @else
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpa</th>
                        <th>Aksi</th>
                    </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($data as $i => $r)
                    @if($mode == 'detail_siswa')
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->nis }}</td>
                        <td>{{ $r->nama_siswa }}</td>
                        @if(!$tanggal)
                        <td>{{ $statusMap[$r->id] ? \Carbon\Carbon::parse($statusMap[$r->id]['tanggal'])->translatedFormat('d M Y') : '-' }}</td>
                        @endif
                        <td>
                            @php $st = $statusMap[$r->id]['status'] ?? '-'; @endphp
                            @if($st === 'hadir') <span class="rekap-badge badge-hadir">Hadir</span>
                            @elseif($st === 'izin') <span class="rekap-badge badge-izin">Izin</span>
                            @elseif($st === 'sakit') <span class="rekap-badge badge-sakit">Sakit</span>
                            @elseif($st === 'alpa') <span class="rekap-badge badge-alpa">Alpa</span>
                            @else <span>-</span> @endif
                        </td>
                    </tr>
                    @elseif($tanggal && !$kelasId)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $r->nama_kelas }}</strong></td>
                        <td>{{ $r->total }}</td>
                        <td><span class="rekap-badge badge-hadir">{{ $r->hadir }}</span></td>
                        <td><span class="rekap-badge badge-izin">{{ $r->izin }}</span></td>
                        <td><span class="rekap-badge badge-sakit">{{ $r->sakit }}</span></td>
                        <td><span class="rekap-badge badge-alpa">{{ $r->alpa }}</span></td>
                        <td>
                            <a href="{{ route('admin.rekap-absensi.index', ['tanggal' => $tanggal, 'kelas_id' => $r->kelas_id]) }}" class="detail-button" style="text-decoration:none;">Lihat Detail</a>
                        </td>
                    </tr>
                    @elseif(!$tanggal && $kelasId)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</strong></td>
                        <td>{{ $r->total }}</td>
                        <td><span class="rekap-badge badge-hadir">{{ $r->hadir }}</span></td>
                        <td><span class="rekap-badge badge-izin">{{ $r->izin }}</span></td>
                        <td><span class="rekap-badge badge-sakit">{{ $r->sakit }}</span></td>
                        <td><span class="rekap-badge badge-alpa">{{ $r->alpa }}</span></td>
                        <td>
                            <a href="{{ route('admin.rekap-absensi.index', ['tanggal' => $r->tanggal, 'kelas_id' => $kelasId]) }}" class="detail-button" style="text-decoration:none;">Lihat Detail</a>
                        </td>
                    </tr>
                    @elseif(!$tanggal && !$kelasId && $status)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $r->nama_kelas }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                        <td><span class="rekap-badge badge-{{ $status }}">{{ $r->hadir ?: $r->izin ?: $r->sakit ?: $r->alpa }}</span></td>
                    </tr>
                    @else
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                        <td><strong>{{ $r->nama_kelas }}</strong></td>
                        <td><span class="rekap-badge badge-hadir">{{ $r->hadir }}</span></td>
                        <td><span class="rekap-badge badge-izin">{{ $r->izin }}</span></td>
                        <td><span class="rekap-badge badge-sakit">{{ $r->sakit }}</span></td>
                        <td><span class="rekap-badge badge-alpa">{{ $r->alpa }}</span></td>
                        <td>
                            <a href="{{ route('admin.rekap-absensi.index', ['tanggal' => $r->tanggal, 'kelas_id' => $r->kelas_id]) }}" class="detail-button" style="text-decoration:none;">Lihat Detail</a>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:#888;">Tidak ada data absensi yang sesuai dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rekap-table-footer">
            <span>Menampilkan {{ count($data) }} baris data</span>
        </div>
    </section>

</div>

<style>
    .admin-rekap {
        width: 100%;
        min-width: 0;
        color: #263b35;
        font-family: inherit;
    }

    .admin-rekap *,
    .admin-rekap *::before,
    .admin-rekap *::after {
        box-sizing: border-box;
    }

    .rekap-heading {
        margin: 0 0 17px;
    }

    .rekap-heading h1 {
        margin: 0;
        color: #17211f;
        font-size: 25px;
        font-weight: 700;
        line-height: 1.35;
    }

    .rekap-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    .rekap-filter {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: end;
        gap: 12px;
        margin-bottom: 16px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e0e7e4;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(27, 55, 43, 0.05);
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 5px;
    }

    .filter-field label {
        color: #40534b;
        font-size: 11px;
        font-weight: 600;
    }

    .filter-field input,
    .filter-field select {
        width: 100%;
        min-width: 0;
        height: 34px;
        padding: 0 9px;
        color: #46574f;
        background: #fff;
        border: 1px solid #dce4e0;
        border-radius: 5px;
        font: inherit;
        font-size: 11px;
        outline: none;
    }

    .filter-field input:focus,
    .filter-field select:focus {
        border-color: #24734e;
        box-shadow: 0 0 0 2px rgba(36, 115, 78, 0.1);
    }

    .bahan-filter-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-width: 95px;
        height: 34px;
        padding: 0 13px;
        color: #fff;
        background: #145b3c;
        border: none;
        border-radius: 5px;
        font: inherit;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .bahan-filter-button:hover {
        background: #10482f;
    }

    .rekap-table-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e7e4;
        border-radius: 8px;
    }

    .rekap-table-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 12px 13px 8px;
    }

    .rekap-table-heading>span {
        color: #17844e;
        font-size: 16px;
    }

    .rekap-table-heading h2 {
        margin: 0;
        color: #284239;
        font-size: 13px;
        font-weight: 700;
    }

    .rekap-table-scroll {
        width: 100%;
        overflow-x: auto;
        padding: 0 10px;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 10px;
    }

    .rekap-table thead {
        background: #edf6f0;
    }

    .rekap-table th {
        padding: 9px 7px;
        color: #52685c;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rekap-table td {
        padding: 7px;
        color: #36463e;
        border-bottom: 1px solid #edf0ee;
        white-space: nowrap;
    }

    .rekap-table tbody tr:hover {
        background: #f8fbf9;
    }

    .rekap-table tbody tr:last-child td {
        border-bottom: none;
    }

    .rekap-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 23px;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }

    .badge-hadir {
        color: #247448;
        background: #d8f2e2;
    }

    .badge-izin {
        color: #946800;
        background: #fff0c9;
    }

    .badge-sakit {
        color: #b83e48;
        background: #ffe0e1;
    }

    .badge-alpa {
        color: #475b52;
        background: #edf1ef;
    }

    .detail-button {
        padding: 5px 9px;
        color: #fff;
        background: #246b49;
        border: none;
        border-radius: 4px;
        font: inherit;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
        display: inline-block;
    }

    .detail-button:hover {
        background: #1c5339;
    }

    .rekap-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 14px;
    }

    .rekap-table-footer>span {
        color: #53665c;
        font-size: 11px;
    }

    @media (max-width: 900px) {
        .rekap-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .rekap-heading h1 {
            font-size: 21px;
        }

        .rekap-filter {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection