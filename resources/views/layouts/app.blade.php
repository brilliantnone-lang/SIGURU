<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIGURU - Jurnal Mengajar Harian Guru')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;   /* biar tidak ada scroll di body */
            background: #f5f5f5;
        }

        /* ===== WRAPPER UTAMA (Flex Kolom: Header -> Main -> Footer) ===== */
        .app-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* ===== HEADER (Full width, gradasi hijau ke hijau muda) ===== */
        .app-header {
            height: 75px;
            background: linear-gradient(135deg, #1e4630 0%, #52b788 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
            z-index: 100;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-brand .logo-icon {
            font-size: 28px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header-brand-text h5 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.3;
            color: white;
            letter-spacing: 0.3px;
        }

        .header-user { display: flex; align-items: center; gap: 16px; }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 16px 6px 6px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: #1e4630; color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }
        .user-detail h6 { margin: 0; font-size: 13px; font-weight: 700; color: #111827; }
        .user-detail p { margin: 0; font-size: 11px; color: #4b5563; }

        .btn-logout {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; 
            background: transparent; 
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.6); 
            border-radius: 8px;
            font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(255, 255, 255, 0.2); color: white; }

        /* ===== MAIN CONTAINER (Sidebar + Content) ===== */
        .app-main {
            flex: 1;
            display: flex;
            overflow: hidden; /* Biar sidebar & content bisa scroll mandiri */
        }

        /* ===== SIDEBAR (Di bawah header, bisa di-scroll) ===== */
        .sidebar {
            width: 270px;
            background: #1e4630; /* Hijau gelap sidebar */
            color: white;
            flex-shrink: 0;
            overflow-y: auto;   
            height: 100%;
        }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }

        .sidebar-section {
            padding: 16px 24px 8px;
            font-size: 11px; 
            font-weight: 600;
            letter-spacing: 0.8px; 
            opacity: 0.6;
            text-transform: uppercase;
        }
        .sidebar-menu { list-style: none; padding: 0 16px; margin: 0; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 8px;
            font-size: 13.5px; 
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-menu a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a.active { 
            background: #a3bfa8; /* Hijau muda abu-abu sesuai gambar referensi */
            color: #111827; 
            font-weight: 600; 
        }
        .sidebar-menu a i { font-size: 16px; width: 20px; text-align: center; }

        /* ===== CONTENT (Area konten utama, bisa di-scroll) ===== */
        .app-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px;
            background: #f4f6f5;
        }

        /* ===== FOOTER (Full width di bagian paling bawah) ===== */
        .app-footer {
            height: 40px;
            background: #4b5563; /* Abu-abu gelap sesuai gambar */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            font-size: 11.5px;
            color: #d1d5db;
            flex-shrink: 0;
            z-index: 100;
        }

        /* ===== CARD ===== */
        .card-custom {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="app-wrapper">

    {{-- HEADER (Full width, Logo di kiri, User & Logout di kanan) --}}
    <header class="app-header">
        <div class="header-brand">
            <div class="logo-icon">
                <i class="bi bi-journal-check"></i>
            </div>
            <div class="header-brand-text">
                <h5>JURNAL MENGAJAR<br>HARIAN GURU</h5>
            </div>
        </div>

        <div class="header-user">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="user-detail">
                    <h6>{{ Auth::user()->name ?? 'Admin Kurikulum' }}</h6>
                    <p>
                        @if(isset(Auth::user()->role) && Auth::user()->role === 'admin') Admin
                        @elseif(isset(Auth::user()->role) && Auth::user()->role === 'kepsek') Kepala Sekolah
                        @else Admin Kurikulum
                        @endif
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- MAIN (Sidebar + Content) --}}
    <div class="app-main">

        {{-- SIDEBAR (Berada di bawah header, bisa di-scroll) --}}
        <aside class="sidebar">
            <div class="sidebar-section">Menu Utama</div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="#"><i class="bi bi-clipboard-check"></i> Rekapitulasi Absensi Siswa</a></li>
                <li><a href="#"><i class="bi bi-calendar-event"></i> Kalender Akademik</a></li>
                <li><a href="#"><i class="bi bi-journal-text"></i> Jurnal Harian Guru</a></li>
                <li><a href="#"><i class="bi bi-book"></i> Bahan Ajar Guru</a></li>
            </ul>

            <div class="sidebar-section">Pengaturan</div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="bi bi-file-earmark-text"></i> Data Cover</a></li>
                <li><a href="#"><i class="bi bi-people"></i> Data Guru</a></li>
                <li><a href="#"><i class="bi bi-building"></i> Data Kelas</a></li>
                <li><a href="#"><i class="bi bi-journal-bookmark"></i> Data Pengajaran</a></li>
                <li><a href="#"><i class="bi bi-calendar3"></i> Event Sekolah</a></li>
                <li><a href="#"><i class="bi bi-question-circle"></i> Panduan Penggunaan</a></li>
            </ul>
        </aside>

        {{-- CONTENT (Scrollable) --}}
        <main class="app-content">
            @yield('content')
        </main>

    </div>

    {{-- FOOTER (Full width di bawah) --}}
    <footer class="app-footer">
        <span>© {{ date('Y') }} Jurnal Mengajar Guru</span>
        <span>V.01.00</span>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>