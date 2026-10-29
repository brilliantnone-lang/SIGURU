@extends('layouts.app')

@section('title', 'Jurnal Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">
                Jurnal: {{ $guru->user->name ?? '-' }}
            </h1>
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:5px;">
                <span style="font-size:12px; color:#555;">
                    Semester {{ $cover->semester }} {{ $cover->tahun_ajaran }} 
                </span>
                <span style="background:#e1ece6; padding:2px 8px; border-radius:4px; font-weight:600; font-size:11px; color:#14532d;">
                    {{ $jurnals->count() }} Jurnal
                </span>

                {{-- Tampilkan Status HANYA jika semester sudah selesai --}}
                @if($isSelesai)
                    @if($statusUtama === 'valid')
                        <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:6px; font-weight:700; font-size:11px;">Tervalidasi</span>
                    @elseif($statusUtama === 'menunggu_revisi')
                        <span style="background:#ffe4e6; color:#be123c; padding:4px 10px; border-radius:6px; font-weight:700; font-size:11px;">Perlu Revisi</span>
                    @else
                        <span style="background:#fff0c9; color:#a86600; padding:4px 10px; border-radius:6px; font-weight:700; font-size:11px;">Belum Divalidasi</span>
                    @endif
                @endif
            </div>
        </div>
        <a href="{{ route('kepsek.validasi-jurnal.show', $cover->id) }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif

    {{-- BANNER FORM VALIDASI --}}
    @if($isSelesai)
        <div style="background:#f8faf9; padding:20px; border-radius:12px; border:1px solid #E1ECE6; margin-bottom:25px;">
            <h3 style="margin:0 0 12px; font-size:15px; color:#111;">Validasi Semua Jurnal {{ $guru->user->name ?? '' }}</h3>
            
            <form id="formValidasi" action="{{ route('kepsek.validasi-jurnal.validasi-guru', [$cover->id, $guru->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div id="catatanWrapper" style="display:none; margin-bottom:15px;">
                    <label style="display:block; font-weight:600; margin-bottom:7px; font-size:13px;">Catatan Revisi (Wajib):</label>
                    <textarea name="catatan_validasi" id="catatan_validasi" rows="3" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" placeholder="Tulis catatan perbaikan untuk guru..."></textarea>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" name="status_validasi" value="valid" onclick="return confirm('Validasi SEMUA jurnal guru ini?')" style="flex:1; padding:12px; background:#166534; color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                        <i class="bi bi-check2-circle"></i> Validasi Semua Jurnal
                    </button>
                    <button type="button" onclick="tampilkanCatatan()" style="flex:1; padding:12px; background:#be123c; color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                        <i class="bi bi-exclamation-triangle"></i> Perlu Revisi
                    </button>
                </div>
            </form>
        </div>
    @else
        <div style="background:#fff0c9; color:#a86600; padding:15px 20px; border-radius:8px; border:1px solid #ffe4a1; margin-bottom:25px; font-size:13px;">
            <i class="bi bi-info-circle"></i> Semester ini masih berjalan. Validasi hanya bisa dilakukan setelah semester selesai (sesuai Kalender Akademik).
        </div>
    @endif

    {{-- TABEL DAFTAR JURNAL --}}
    <div style="background:#fff; padding:20px; border-radius:10px; border:1px solid #E1ECE6;">
        <h3 style="margin:0 0 15px; font-size:15px; color:#111;">Daftar Jurnal (Per Tanggal)</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#edf6f0;">
                        <th style="padding:10px; text-align:left;">No.</th>
                        <th style="padding:10px; text-align:left;">Tanggal</th>
                        <th style="padding:10px; text-align:left;">Mata Pelajaran</th>
                        <th style="padding:10px; text-align:left;">Kelas</th>
                        <th style="padding:10px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $i => $j)
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #eee;">{{ $i+1 }}</td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">{{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                            <td style="padding:10px; border-bottom:1px solid #eee; text-align:center;">
                                <a href="{{ route('kepsek.validasi-jurnal.detail', $j->id) }}" style="display:inline-block; padding:4px 10px; background:#176b48; color:#fff; text-decoration:none; border-radius:4px; font-size:11px; font-weight:600;">
                                    Lihat Isi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada jurnal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function tampilkanCatatan() {
        const wrapper = document.getElementById('catatanWrapper');
        const textarea = document.getElementById('catatan_validasi');

        wrapper.style.display = 'block';
        textarea.required = true;
        textarea.focus();

        const btnRevisi = event.target;
        btnRevisi.innerHTML = '<i class="bi bi-send"></i> Kirim Revisi';
        btnRevisi.setAttribute('type', 'submit');
        btnRevisi.setAttribute('name', 'status_validasi');
        btnRevisi.setAttribute('value', 'menunggu_revisi');
        btnRevisi.removeAttribute('onclick');
        btnRevisi.style.background = '#be123c';
    }
</script>
@endpush