@extends('layouts.app')

@section('title', 'Jurnal Harian Guru')

@section('content')
<div style="width:100%; color:#26332F;">

    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin:0 7px 43px; flex-wrap:wrap;">
        <div>
            <h1 style="margin:0 0 5px; font-size:20px; font-weight:700; color:#111;">
                Jurnal Harian Guru
            </h1>
            <p style="margin:0; font-size:14px; font-weight:600; color:#40574F;">
                Melihat catatan kegiatan mengajar guru
            </p>
        </div>

        <a href="{{ route('kepsek.form-validasi.index') }}"
           style="display:inline-flex; align-items:center; justify-content:center; gap:7px;
                  padding:10px 16px; border:1px solid #064E3B; border-radius:7px;
                  background:#064E3B; color:#fff; text-decoration:none;
                  font-size:12px; font-weight:600; min-width:130px;">
            <i class="bi bi-check2"></i>
            Validasi Jurnal
        </a>
    </div>

    {{-- INFORMASI GURU --}}
    <div style="padding:12px; margin-bottom:32px; border:1px solid #E1ECE6;
                border-radius:2px; background:#fff; font-size:10px; color:#7A8982;">
        Nama Guru :
        <strong style="margin-left:5px; color:#777; font-weight:700;">
            {{ $jurnal->guru->user->name ?? '-' }}
        </strong>
    </div>

    {{-- TABEL JURNAL --}}
    <div style="background:#fff; border:1px solid #E1ECE6; border-radius:8px;
                padding:19px 17px 4px; overflow:hidden;">

        <div style="width:100%; overflow-x:auto;">
            <table style="width:100%; min-width:850px; border-collapse:collapse;
                          font-size:8px; color:#203E36;">

                <thead>
                    <tr style="background:#EAF6F0;">
                        <th style="padding:15px 6px; text-align:center;">No.</th>
                        <th style="padding:15px 6px; text-align:left;">Hari / Tanggal</th>
                        <th style="padding:15px 6px; text-align:left;">Kelas</th>
                        <th style="padding:15px 6px; text-align:left;">Jam Pelajaran</th>
                        <th style="padding:15px 6px; text-align:left;">Pokok Bahasan</th>
                        <th style="padding:15px 6px; text-align:left;">Selesai / Belum Selesai + Alasan</th>
                        <th style="padding:15px 6px; text-align:left;">Absensi Siswa</th>
                        <th style="padding:15px 6px; text-align:left;">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Gunakan perulangan ini jika $jurnal merupakan koleksi --}}
                    @foreach($jurnal as $item)
                    <tr style="border-bottom:1px solid #E8EFEB;">

                        <td style="padding:10px 6px; text-align:center; vertical-align:top;">
                            {{ $loop->iteration }}
                        </td>

                        {{-- HARI / TANGGAL --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            @if($item->tanggal)
                                <div>{{ $item->tanggal->translatedFormat('l,') }}</div>
                                <div>{{ $item->tanggal->translatedFormat('d F Y') }}</div>
                            @else
                                -
                            @endif
                        </td>

                        {{-- KELAS --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            {{ $item->kelas->nama_kelas ?? '-' }}
                        </td>

                        {{-- JAM PELAJARAN --}}
                        <td style="padding:10px 6px; vertical-align:top; white-space:nowrap;">
                            {{ $item->jam_mulai_ke ?? '-' }}–{{ $item->jam_selesai_ke ?? '-' }}
                        </td>

                        {{-- POKOK BAHASAN --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            {{ $item->pokok_bahasan ?? '-' }}
                        </td>

                        {{-- STATUS PENYELESAIAN --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            @if($item->status_penyelesaian == 'selesai')
                                <span style="display:inline-block; padding:4px 12px;
                                             border-radius:20px; background:#D8F3E3;
                                             color:#16804A; white-space:nowrap; font-size:7px;">
                                    Selesai
                                </span>
                                <div style="margin-top:7px; color:#89958E;">-</div>
                            @else
                                <span style="display:inline-block; padding:4px 12px;
                                             border-radius:20px; background:#FFF0D9;
                                             color:#B96A00; white-space:nowrap; font-size:7px;">
                                    Belum selesai
                                </span>
                                <div style="margin-top:7px; color:#89958E; line-height:1.45;">
                                    {{ $item->alasan_belum_selesai ?? '-' }}
                                </div>
                            @endif
                        </td>

                        {{-- ABSENSI SISWA --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            Hadir: -<br>
                            Sakit: -
                        </td>

                        {{-- KETERANGAN --}}
                        <td style="padding:10px 6px; vertical-align:top;">
                            {{ $item->keterangan ?? '-' }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection