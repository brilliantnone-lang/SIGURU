<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jurnal Mengajar Guru')</title>

    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        :root {
            --green-dark: #0A4C2E;
            --green-main: #17B26C;
            --green-sidebar: #39745E;
            --green-button: #107449;
            --text-main: #173D2B;
            --text-muted: #40574F;
            --border: #E1ECE6;
            --footer: #4B5552;
            --white: #FFFFFF;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: 'Titillium Web', Arial, sans-serif;
            color: var(--text-main);
            background: var(--white);
            font-size: 14px;
        }

        /* ===== APP (flex column) ===== */
        .app {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        /* ===== HEADER (full width, 2 sisi) ===== */
        .topbar {
            flex-shrink: 0;
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;   /* KIRI & KANAN */
            gap: 12px;
            padding: 0 16px;
            background: linear-gradient(90deg, #39745E 0%, #7AD9B3 100%);
            z-index: 100;
        }

        /* Brand di header (kiri) */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #FFFFFF;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 600;
        }
        .topbar-brand .brand-icon {
            font-size: 28px;
            color: #FFFFFF;
            display: flex;
            align-items: center;
        }

        /* Sisi kanan: profil + logout */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile {
            height: 44px;
            width: 210px;
            border-radius: 22px;
            background: rgba(217, 217, 217, 0.54);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 10px;
            color: #000000;
        }

        .avatar {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 2px solid #fff;
            border-radius: 50%;
            background: radial-gradient(circle, #0DFF00 0%, #AFF093 50%, #FFFFFF 100%);
            box-shadow: 0 0 0 1px #6B987D;
            font-size: 20px;
            font-weight: 600;
        }

        .profile-name {
            font-size: 12px;
            line-height: 1.5;
            font-weight: 600;
        }

        .logout {
            width: 94px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid #FF0000;
            border-radius: 7px;
            color: #FF0000;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            background: transparent;
            cursor: pointer;
            transition: all 0.2s;
        }
        .logout:hover { background: rgba(255,0,0,0.1); }

        .logout-icon {
            font-size: 17px;
            line-height: 1;
        }

        /* ===== APP BODY (sidebar + content) ===== */
        .app-body {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px;
            flex: 0 0 250px;
            display: flex;
            flex-direction: column;
            color: var(--white);
            background: var(--green-sidebar);
            overflow-y: auto;
            height: 100%;
        }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }

        .section-label {
            padding: 14px 12px 6px;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .nav {
            padding: 0 8px 10px 10px;
            flex-shrink: 0;
        }

        .nav-item {
            display: block;
            padding: 10px 12px;
            margin-bottom: 3px;
            border-radius: 18px;
            color: var(--white);
            font-size: 14px;
            line-height: 1.35;
            text-decoration: none;
            white-space: normal;
            transition: all 0.2s;
        }
        .nav-item:hover {
            color: var(--white);
            background: rgba(255,255,255,0.1);
            text-decoration: none;
        }
        .nav-item.active {
            background: rgba(225, 236, 230, 0.32);
            box-shadow: inset 0 0 0 1px rgba(225, 236, 230, 0.25);
            color: #000000;
            font-weight: 700;
        }
        .nav-item.active:hover { color: #000000; }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 34px 28px 30px;
            background: #FFFFFF;
        }

        /* ===== FOOTER ===== */
        .main-footer {
            flex-shrink: 0;
            width: 100%;
            min-height: 44px;
            padding: 0 16px;
            background: var(--footer);
            color: #FFFFFF;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ===== CARD ===== */
        .card-custom {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        /* ===== RESPONSIF ===== */
        @media (max-width: 900px) {
            .sidebar { width: 220px; flex-basis: 220px; }
            .content { padding: 26px 18px; }
        }
        @media (max-width: 600px) {
            .sidebar { width: 155px; flex-basis: 155px; }
            .nav-item { padding: 8px; font-size: 12px; }
            .topbar { padding: 0 8px; gap: 6px; }
            .topbar-brand { font-size: 11px; }
            .topbar-brand .brand-icon { font-size: 20px; }
            .profile { width: auto; padding: 3px; }
            .profile-name { font-size: 10px; }
            .content { padding: 22px 12px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="app">

    {{-- HEADER (2 sisi: brand kiri, profil+logout kanan) --}}
    <header class="topbar">

        {{-- KIRI: Brand --}}
        <div class="topbar-brand">
            <div class="brand-icon">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>JURNAL MENGAJAR<br>HARIAN GURU</div>
        </div>

        {{-- KANAN: Profil + Logout --}}
        <div class="topbar-right">
            <div class="profile">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="profile-name">
                    {{ Auth::user()->name ?? 'Admin Kurikulum' }}<br>
                    @if(Auth::user()->role === 'admin') Admin
                    @elseif(Auth::user()->role === 'kepsek') Kepala Sekolah
                    @else Guru
                    @endif
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="logout">
                    <span class="logout-icon">⇥</span>
                    Keluar
                </button>
            </form>
        </div>

    </header>

    {{-- APP BODY (sidebar + content) --}}
    <div class="app-body">

        {{-- SIDEBAR --}}
        @include('partials.sidebar-' . Auth::user()->role)

        {{-- CONTENT --}}
        <section class="content">
            @yield('content')
        </section>

    </div>

    {{-- FOOTER --}}
    <footer class="main-footer">
        <span>© {{ date('Y') }} Jurnal Mengajar Guru</span>
        <span>V.01.00</span>
    </footer>

</div>

@stack('scripts')
</body>
</html>