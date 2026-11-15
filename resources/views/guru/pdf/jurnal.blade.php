<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Jurnal Harian Guru</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', 'DejaVu Serif', serif;
            font-size: 11px;
            color: #222;
            line-height: 1.4;
            margin: 0;
        }

        /* KOP SURAT */
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
            position: relative;
        }

        .kop .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
            height: 70px;
        }

        .kop .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .kop-text {
            margin-left: 80px;
            margin-right: 80px;
        }

        .kop h1 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .kop h2 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .kop h3 {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .kop p {
            margin: 0;
            font-size: 10px;
            line-height: 1.3;
        }

        /* JUDUL */
        .judul {
            text-align: center;
            margin: 15px 0;
        }

        .judul h1 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* INFO GURU */
        .info-guru {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-guru table {
            border-collapse: collapse;
        }

        .info-guru td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .info-guru td:first-child {
            width: 130px;
            font-weight: 400;
        }

        .info-guru td:nth-child(2) {
            width: 10px;
        }

        /* TABEL JURNAL */
        .jurnal-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }

        /* ===== MARGIN ISI JURNAL ===== */
        .journal-content {
            width: 186mm;
            margin: 0 auto;
            padding: 15mm 0;
            box-sizing: border-box;
        }

        .jurnal-table th {
            border: 1px solid #000;
            padding: 5px 4px;
            background: #f0f0f0;
            text-align: center;
            font-weight: 700;
            font-size: 10px;
            vertical-align: middle;
        }

        .jurnal-table td {
            border: 1px solid #000;
            padding: 5px 4px;
            vertical-align: top;
            font-size: 9.5px;
        }

        .jurnal-table th,
        .jurnal-table td {
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        /* Lebar masing-masing kolom */
        .jurnal-table th:nth-child(1),
        .jurnal-table td:nth-child(1) {
            width: 4%;
            text-align: center;
        }

        .jurnal-table th:nth-child(2),
        .jurnal-table td:nth-child(2) {
            width: 13%;
            text-align: center;
        }

        .jurnal-table th:nth-child(3),
        .jurnal-table td:nth-child(3) {
            width: 11%;
            text-align: center;
        }

        .jurnal-table th:nth-child(4),
        .jurnal-table td:nth-child(4) {
            width: 34%;
        }

        .jurnal-table th:nth-child(5),
        .jurnal-table td:nth-child(5) {
            width: 15%;
            text-align: center;
        }

        .jurnal-table th:nth-child(6),
        .jurnal-table td:nth-child(6) {
            width: 23%;
        }

        .jurnal-table tr {
            page-break-inside: avoid;
        }

        .status-selesai {
            color: #166534;
            font-weight: 600;
        }

        .status-belum {
            color: #be123c;
            font-weight: 600;
        }

        .alasan-text {
            font-size: 9px;
            color: #555;
            font-style: italic;
            margin-top: 3px;
        }

        .absensi-text {
            font-size: 9px;
            line-height: 1.5;
        }

        .absensi-text strong {
            font-weight: 700;
        }

        .absensi-hadir {
            color: #166534;
        }

        .absensi-sakit {
            color: #304fbb;
        }

        .absensi-izin {
            color: #967000;
        }

        .absensi-alpa {
            color: #555;
        }

        /* TTD */
        .ttd-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }

        .ttd-label {
            font-size: 11px;
            margin-bottom: 5px;
        }

        .ttd-space {
            height: 70px;
            position: relative;
        }

        .ttd-image {
            max-width: 100px;
            max-height: 70px;
            object-fit: contain;
        }

        .ttd-nama {
            font-size: 11px;
            font-weight: 700;
            text-decoration: underline;
            margin-top: 5px;
        }

        .ttd-nip {
            font-size: 10px;
            margin-top: 2px;
        }

        .ttd-guru {
            font-size: 11px;
            font-weight: 700;
            text-decoration: underline;
        }




        /* ===== COVER JURNAL ===== */

        .cover-page {
            position: relative;
            width: 170mm;
            box-sizing: border-box;
            padding: 25mm 0;
            margin: 0 auto;
            text-align: center;
            page-break-after: always;
            color: #29251e;
            font-family: 'Times New Roman', serif;
        }

        .cover-background {
            position: absolute;
            top: -25mm;
            left: -20mm;
            width: 210mm;
            height: 322mm;
            background-color: #F3E7C2;
            z-index: 0;
        }

        .cover-content {
            position: relative;
            z-index: 1;
        }


        .cover-logo {
            width: 105px;
            height: 105px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .cover-heading {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            line-height: 1.5;
            text-transform: uppercase;
            margin: 0;
        }

        .cover-school {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .cover-title {
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.35;
            margin-top: 38px;
            margin-bottom: 48px;
            color: #30291e;
        }


        .cover-info-wrapper {
            width: 145mm;
            max-width: 100%;
            margin: 0 auto;
            border: 1.5px solid #B99A50;
            border-radius: 10px;
            padding: 12px 16px;
            box-sizing: border-box;
            background-color: transparent;
        }

        .cover-info {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 12px;
            line-height: 1.5;
            text-align: left;
        }

        .cover-info td {
            padding: 5px 3px;
            vertical-align: middle;
        }

        .cover-info td:first-child {
            width: 34%;
        }

        .cover-info td:nth-child(2) {
            width: 4%;
            text-align: center;
        }

        .cover-info td:nth-child(3) {
            width: 62%;
        }
    </style>
</head>

<body>


    {{-- HALAMAN COVER --}}
    <div class="cover-page">

        <div class="cover-background"></div>

        <div class="cover-content">

            {{-- LOGO --}}
            @if($logoSekolah)
                <img src="{{ $logoSekolah }}" alt="Logo Sekolah" class="cover-logo">
            @endif

            {{-- KOP INSTANSI --}}
            <div class="cover-heading">
                PEMERINTAH KOTA/KABUPATEN
            </div>

            <div class="cover-heading">
                DINAS PENDIDIKAN
            </div>

            <div class="cover-heading">
                SEKOLAH MENENGAH PERTAMA
            </div>

            <div class="cover-heading">
                (SMP)
            </div>

            {{-- NAMA SEKOLAH --}}
            <div class="cover-school">
                {{ $cover->nama_sekolah }}
            </div>

            {{-- JUDUL --}}
            <div class="cover-title">
                JURNAL HARIAN<br>
                GURU
            </div>

            {{-- IDENTITAS --}}
            <div class="cover-info-wrapper">
                <table class="cover-info">
                    <tr>
                        <td>Nama Guru</td>
                        <td>:</td>
                        <td>{{ $namaGuru }}</td>
                    </tr>

                    <tr>
                        <td>NIP Guru</td>
                        <td>:</td>
                        <td>{{ $nipGuru }}</td>
                    </tr>

                    <tr>
                        <td>Nama Sekolah</td>
                        <td>:</td>
                        <td>{{ $cover->nama_sekolah }}</td>
                    </tr>

                    <tr>
                        <td>Alamat Sekolah</td>
                        <td>:</td>
                        <td>{{ $cover->alamat ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>{{ $cover->tahun_ajaran }}</td>
                    </tr>

                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>{{ $cover->semester }}</td>
                    </tr>
                </table>
            </div>

        </div> {{-- Penutup cover-content --}}

    </div> {{-- Penutup cover-page --}}
    {{-- AKHIR HALAMAN COVER --}}
    <div class="journal-content">

        {{-- KOP SURAT --}}
        <div class="kop">
            @if($logoSekolah)
                <div class="logo">
                    <img src="{{ $logoSekolah }}" alt="Logo Sekolah">
                </div>
            @endif

            <div class="kop-text">
                <h1>Pemerintah Kota/Kabupaten</h1>
                <h2>Dinas Pendidikan</h2>
                <h3>Sekolah Menengah Pertama (SMP)</h3>
                <p>{{ $cover->nama_sekolah }}</p>
                <p>{{ $cover->alamat ?? '-' }}</p>
                @if($cover->npsn)
                    <p>NPSN: {{ $cover->npsn }}</p>
                @endif
            </div>
        </div>

        {{-- JUDUL --}}
        <div class="judul">
            <h1>Jurnal Harian Guru</h1>
        </div>

        {{-- INFO GURU --}}
        <div class="info-guru">
            <table>
                <tr>
                    <td>Nama Guru</td>
                    <td>:</td>
                    <td>{{ $namaGuru }}</td>
                </tr>
                <tr>
                    <td>Nama Sekolah</td>
                    <td>:</td>
                    <td>{{ $cover->nama_sekolah }}</td>
                </tr>
                <tr>
                    <td>Alamat Sekolah</td>
                    <td>:</td>
                    <td>{{ $cover->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tahun Ajaran</td>
                    <td>:</td>
                    <td>{{ $cover->tahun_ajaran }} Semester {{ $cover->semester }}</td>
                </tr>
            </table>
        </div>

        {{-- TABEL JURNAL --}}
        <table class="jurnal-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari / Tanggal</th>
                    <th>Kelas / Jam Pelajaran</th>
                    <th>Pokok Bahasan / Mata Pelajaran</th>
                    <th>Selesai / Belum Selesai</th>
                    <th>Absensi Siswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnals as $index => $jurnal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d M Y') : '-' }}
                        </td>
                        <td>
                            <strong>{{ $jurnal->kelas->nama_kelas ?? '-' }}</strong><br>
                            Jam ke-{{ $jurnal->jam_mulai_ke }}-{{ $jurnal->jam_selesai_ke }}
                        </td>
                        <td>
                            <strong>{{ $jurnal->pokok_bahasan ?: '-' }}</strong><br>
                            <em>{{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</em>
                        </td>
                        <td>
                            @if($jurnal->status_penyelesaian === 'selesai')
                                <span class="status-selesai">Selesai</span>
                            @else
                                <span class="status-belum">Belum Selesai</span>
                                @if($jurnal->alasan_belum_selesai)
                                    <div class="alasan-text">{{ $jurnal->alasan_belum_selesai }}</div>
                                @endif
                            @endif
                        </td>
                        <td class="absensi-text">
                            @php
                                $sakit = $jurnal->attendances->where('status_kehadiran', 'sakit');
                                $izin = $jurnal->attendances->where('status_kehadiran', 'izin');
                                $alpa = $jurnal->attendances->where('status_kehadiran', 'alpa');
                            @endphp

                            <div class="absensi-sakit">
                                <strong>Sakit ({{ $sakit->count() }}):</strong>
                                {{ $sakit->count() > 0 ? $sakit->map(fn($a) => $a->murid->nama_siswa ?? '-')->implode(', ') : '-' }}
                            </div>
                            <div class="absensi-izin">
                                <strong>Izin ({{ $izin->count() }}):</strong>
                                {{ $izin->count() > 0 ? $izin->map(fn($a) => $a->murid->nama_siswa ?? '-')->implode(', ') : '-' }}
                            </div>
                            <div class="absensi-alpa">
                                <strong>Alpha ({{ $alpa->count() }}):</strong>
                                {{ $alpa->count() > 0 ? $alpa->map(fn($a) => $a->murid->nama_siswa ?? '-')->implode(', ') : '-' }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:15px; font-style:italic; color:#777;">
                            Belum ada jurnal tervalidasi untuk semester ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- TTD --}}
        <div class="ttd-section">
            <table class="ttd-table">
                <tr>
                    {{-- KIRI: Guru --}}
                    <td>
                        <div class="ttd-label">Mengetahui,</div>
                        <div class="ttd-label"><strong>Guru Mata Pelajaran</strong></div>
                        <div class="ttd-space"></div>
                        <div class="ttd-guru">{{ $namaGuru }}</div>
                        <div class="ttd-nip">NIP. {{ $nipGuru }}</div>
                    </td>

                    {{-- KANAN: Kepsek --}}
                    <td>
                        <div class="ttd-label">{{ $cover->nama_sekolah }},
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                        </div>
                        <div class="ttd-label"><strong>Kepala Sekolah</strong></div>
                        <div class="ttd-space">
                            @if($ttdKepsek)
                                <img src="{{ $ttdKepsek }}" class="ttd-image" alt="TTD Kepsek">
                            @endif
                        </div>
                        <div class="ttd-nama">{{ $cover->nama_kepsek }}</div>
                        <div class="ttd-nip">NIP. {{ $cover->nip_kepsek }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>