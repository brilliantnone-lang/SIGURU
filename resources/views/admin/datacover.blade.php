<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Cover - Jurnal Mengajar Guru</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --green-dark: #0A4C2E;
            --green-main: #17B26C;
            --green-sidebar: #39745E;
            --green-button: #107449;
            --text-main: #173D2B;
            --text-muted: #40574F;
            --border: #E1ECE6;
            --footer: #26332F;
            --white: #FFFFFF;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            width: 100%;
            font-family: 'Titillium Web', Arial, sans-serif;
            color: var(--text-main);
            background: var(--white);
        }

        body {
            min-height: 100vh;
            font-size: 12px;
        }

        .app {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            min-height: 100vh;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 166px;
            flex: 0 0 166px;
            display: flex;
            flex-direction: column;
            color: var(--white);
            background: #39745E;
        }

        .brand {
            min-height: 60px;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            font-size: 10px;
            line-height: 1.5;
            font-weight: 600;
        }

        .brand-icon {
            position: relative;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
        }

        .brand-icon .person {
            position: absolute;
            top: 0;
            left: 7px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: var(--white);
        }

        .brand-icon .person::after {
            content: "";
            position: absolute;
            top: 13px;
            left: -4px;
            width: 21px;
            height: 12px;
            background: var(--white);
            border-radius: 8px 8px 2px 2px;
        }

        .brand-icon .paper {
            position: absolute;
            right: 0;
            bottom: 1px;
            width: 23px;
            height: 25px;
            background: #39745E;
            border: 2px solid var(--white);
            border-radius: 3px;
            transform: rotate(-8deg);
        }

        .brand-icon .paper::before {
            content: "▤";
            position: absolute;
            top: 1px;
            left: 2px;
            font-size: 16px;
            color: var(--white);
        }

        .section-label {
            padding: 2px 9px 5px;
            font-size: 8px;
            font-weight: 700;
        }

        .nav {
            padding: 0 5px 8px 10px;
        }

        .nav-item {
            display: block;
            padding: 6px 10px;
            margin-bottom: 1px;
            border-radius: 18px;
            color: var(--white);
            font-size: 11px;
            line-height: 1.25;
            text-decoration: none;
            white-space: nowrap;
        }

        .nav-item.active {
            background: rgba(225, 236, 230, 0.32);
            box-shadow: inset 0 0 0 1px rgba(225, 236, 230, 0.25);
            color: #000000;
            font-weight: 700;
        }

        .nav-item.active:visited,
        .nav-item.active:hover,
        .nav-item.active:focus {
            color: #000000;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 8px 9px;
            font-size: 7px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* HEADER */
        .main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            min-height: 45px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 0 7px;
            background: linear-gradient(90deg, #39745E 0%, #7AD9B3 100%);
        }

        .profile {
            height: 34px;
            width: 145px;
            border-radius: 22px;
            background: rgba(217, 217, 217, 0.54);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 3px 7px;
            color: #000000;
        }

        .avatar {
            width: 27px;
            height: 27px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 2px solid var(--white);
            border-radius: 50%;
            background: radial-gradient(circle,
                    #0DFF00 0%,
                    #AFF093 50%,
                    #FFFFFF 100%);
            box-shadow: 0 0 0 1px #6B987D;
            font-size: 17px;
            font-weight: 600;
        }

        .profile-name {
            font-size: 7px;
            line-height: 1.5;
            font-weight: 600;
        }

        .logout {
            width: 66px;
            min-height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            border: 1px solid #FF0000;
            border-radius: 7px;
            color: #FF0000;
            font-size: 10px;
            font-weight: 600;
        }

        .logout-icon {
            font-size: 17px;
            line-height: 1;
        }

        /* KONTEN */
        .content {
            flex: 1;
            min-width: 0;
            padding: 25px 7px 20px 17px;
            background: #FFFFFF;
        }

        h1 {
            margin: 0 0 5px 10px;
            color: #000000;
            font-size: 16px;
            line-height: 1.3;
            font-weight: 600;
        }

        .subtitle {
            margin: 0 0 9px 10px;
            color: #40574F;
            font-size: 11px;
            font-weight: 600;
        }

        .settings-card {
            min-height: 325px;
            padding: 7px;
            border: 1px solid #E1ECE6;
            border-radius: 8px;
            background: #FFFFFF;
        }

        .settings-inner {
            padding: 5px 4px 4px;
            border-radius: 6px;
            background: rgba(228, 236, 231, 0.12);
        }

        .settings-title {
            margin: 0 0 2px;
            color: #173D2B;
            font-size: 11px;
            font-weight: 600;
        }

        .settings-description {
            margin: 0 0 12px;
            color: #5D756B;
            font-size: 7px;
        }

        .field-label {
            display: block;
            margin-bottom: 4px;
            color: #173D2B;
            font-size: 7px;
            font-weight: 600;
        }

        .field-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 16px;
            margin-bottom: 9px;
        }

        .field {
            min-width: 0;
        }

        .input {
            display: block;
            width: 100%;
            height: 19px;
            padding: 3px 6px;
            border: 1px solid #E1ECE6;
            border-radius: 3px;
            outline: none;
            background: #FFFFFF;
            color: #40574F;
            font: inherit;
            font-size: 7px;
        }

        .school-field {
            margin-bottom: 9px;
        }

        .upload-label {
            margin-bottom: 7px;
        }

        .upload-box {
            height: 103px;
            margin: 0 3px 12px;
            padding: 9px;
            border: 1px solid #E1ECE6;
            border-radius: 9px;
            background: #FFFFFF;
        }

        .upload-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 1px dashed #E1ECE6;
            border-radius: 6px;
            color: #173D2B;
        }

        .cloud-icon {
            width: 31px;
            height: 27px;
            margin-bottom: 3px;
        }

        .upload-title {
            margin-bottom: 2px;
            color: #173D2B;
            font-size: 7px;
            font-weight: 600;
        }

        .upload-text {
            color: #40574F;
            font-size: 7px;
            line-height: 1.6;
        }

        .help-text {
            margin: 0 0 20px;
            color: #5D756B;
            font-size: 7px;
        }

        .button-row {
            display: flex;
            justify-content: flex-end;
        }

        .save-button {
            width: 44%;
            min-height: 20px;
            border: none;
            border-radius: 4px;
            background: #0A4C2E;
            color: #FFFFFF;
            font-family: inherit;
            font-size: 7px;
            font-weight: 600;
        }

        /* FOOTER */
        .main-footer {
            min-height: 27px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            background: #26332F;
            color: #FFFFFF;
            font-size: 7px;
        }

        /* RESPONSIF */
        @media (max-width: 700px) {
            .sidebar {
                width: 150px;
                flex-basis: 150px;
            }

            .content {
                padding: 20px 10px;
            }

            .field-row {
                grid-template-columns: 1fr;
                gap: 9px;
            }

            .profile {
                width: auto;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 125px;
                flex-basis: 125px;
            }

            .brand {
                padding-left: 6px;
                gap: 4px;
            }

            .nav {
                padding-left: 4px;
                padding-right: 3px;
            }

            .nav-item {
                padding: 6px;
                font-size: 10px;
                white-space: normal;
            }

            .topbar {
                gap: 4px;
                padding: 0 4px;
            }

            .profile {
                padding: 3px;
            }
        }

        /* PENYESUAIAN UKURAN: warna dan struktur desain asli tetap dipertahankan */
        body {
            font-size: 14px;
        }

        .app {
            padding: 8px;
        }

        .sidebar {
            width: 250px;
            flex: 0 0 250px;
        }

        .brand {
            min-height: 92px;
            gap: 12px;
            padding: 14px 16px;
            font-size: 14px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
        }

        .section-label {
            padding: 10px 12px 6px;
            font-size: 11px;
        }

        .nav {
            padding: 0 8px 10px 10px;
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
        }

        .nav-item:visited,
        .nav-item:hover,
        .nav-item:focus {
            color: var(--white);
            text-decoration: none;
        }

        .nav-item.active {
            background: rgba(225, 236, 230, 0.32);
            box-shadow: inset 0 0 0 1px rgba(225, 236, 230, 0.25);
            color: #000000;
            font-weight: 700;
        }

        .nav-item.active:visited,
        .nav-item.active:hover,
        .nav-item.active:focus {
            color: #000000;
        }

        .sidebar-footer {
            padding: 12px;
            font-size: 10px;
        }

        .topbar {
            min-height: 68px;
            padding: 0 16px;
            gap: 12px;
        }

        .profile {
            width: 210px;
            height: 44px;
            padding: 5px 10px;
            gap: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            font-size: 20px;
        }

        .profile-name {
            font-size: 12px;
        }

        .logout {
            width: 94px;
            min-height: 44px;
            font-size: 13px;
        }

        .content {
            padding: 34px 28px 30px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .subtitle {
            margin: 0 0 22px;
            font-size: 15px;
        }

        .settings-card {
            min-height: 0;
            padding: 20px;
            border-radius: 12px;
        }

        .settings-inner {
            padding: 10px 12px 14px;
        }

        .settings-title {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .settings-description {
            margin: 0 0 22px;
            font-size: 12px;
        }

        .field-label {
            margin-bottom: 7px;
            font-size: 13px;
        }

        .field-row {
            gap: 22px;
            margin-bottom: 16px;
        }

        .input {
            height: 42px;
            padding: 9px 12px;
            font-size: 13px;
            border-radius: 5px;
        }

        .school-field {
            margin-bottom: 16px;
        }

        .upload-label {
            margin-bottom: 9px;
        }

        .upload-box {
            height: 180px;
            margin: 0 3px 18px;
            padding: 12px;
            border-radius: 10px;
        }

        .upload-inner {
            border-radius: 8px;
        }

        .cloud-icon {
            width: 42px;
            height: 36px;
            margin-bottom: 7px;
        }

        .upload-title {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .upload-text {
            font-size: 13px;
            line-height: 1.6;
        }

        .help-text {
            margin: 0 0 24px;
            font-size: 12px;
        }

        .button-row {
            display: flex;
            justify-content: flex-end;
        }

        .save-button {
            width: 42%;
            min-height: 44px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        .main-footer {
            min-height: 40px;
            padding: 0 18px;
            font-size: 10px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
                flex-basis: 220px;
            }

            .content {
                padding: 26px 18px;
            }

            .field-row {
                grid-template-columns: 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 600px) {
            .app {
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .sidebar {
                width: 155px;
                flex-basis: 155px;
            }

            .brand {
                padding: 10px;
                gap: 7px;
                font-size: 11px;
            }

            .nav-item {
                padding: 8px;
                font-size: 12px;
            }

            .topbar {
                padding: 0 8px;
                gap: 6px;
            }

            .profile {
                width: auto;
            }

            .content {
                padding: 22px 12px;
            }

            .settings-card {
                padding: 10px;
            }

            .save-button {
                width: 100%;
            }
        }


        /* FINAL EDGE-TO-EDGE FIX */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;
            min-height: 100%;
        }

        body {
            overflow-x: hidden;
        }

        .app {
            width: 100%;
            min-height: 100vh;
            margin: 0 !important;
            padding: 0 !important;
        }

        .main {
            min-width: 0;
        }
        /* FOOTER: satu bar penuh di akhir halaman, tidak menempel saat scroll */
        .sidebar-footer {
            display: none;
        }

        .main-footer {
            position: static;
            width: 100%;
            min-height: 44px;
            padding: 0 16px;
            background: #4B5552;
            color: #FFFFFF;
            font-size: 10px;
            margin-top: auto;
        }

        .app {
            min-height: 100vh;
        }

        .main {
            min-height: 100vh;
        }
    


        .sidebar {
            align-self: stretch;
        }

        .main {
            min-width: 0;
            min-height: 100vh;
        }

        .main-footer {
            position: static;
            flex: 0 0 100%;
            width: 100%;
            min-height: 44px;
            margin-top: 0;
            padding: 0 16px;
            background: #4B5552;
            color: #FFFFFF;
            font-size: 10px;
        }

        .sidebar-footer {
            display: none;
        }

    </style>
</head>

<body>
    <div class="app">

        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <span class="person"></span>
                    <span class="paper"></span>
                </div>
                <div>JURNAL MENGAJAR<br>HARIAN GURU</div>
            </div>

            <div class="section-label">MENU UTAMA</div>
            <nav class="nav">
                <a class="nav-item" href="#">Dashboard</a>
                <a class="nav-item" href="#">Rekapitulasi Absensi Siswa</a>
                <a class="nav-item" href="#">Kalender Akademik</a>
                <a class="nav-item" href="#">Jurnal Harian Guru</a>
                <a class="nav-item" href="#">Bahan Ajar Guru</a>
            </nav>

            <div class="section-label">PENGATURAN</div>
            <nav class="nav">
                <a class="nav-item active" href="#">Data Cover</a>
                <a class="nav-item" href="#">Data Guru</a>
                <a class="nav-item" href="#">Data Kelas</a>
                <a class="nav-item" href="#">Data Pengajaran</a>
                <a class="nav-item" href="#">Event Sekolah</a>
                <a class="nav-item" href="#">Panduan Penggunaan</a>
            </nav>

            <div class="sidebar-footer">
                © 2026 Jurnal Mengajar Guru
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="profile">
                    <div class="avatar">A</div>
                    <div class="profile-name">
                        Admin Kurikulum<br>
                        ♟ Admin
                    </div>
                </div>
                <div class="logout">
                    <span class="logout-icon">⇥</span>
                    Keluar
                </div>
            </header>

            <section class="content">
                <h1>Data Cover</h1>
                <p class="subtitle">
                    Atur identitas dan format halaman depan jurnal mengajar guru.
                </p>

                <div class="settings-card">
                    <div class="settings-inner">
                        <h2 class="settings-title">Pengaturan identitas</h2>
                        <p class="settings-description">
                            Perubahan langsung ditampilkan pada pratinjau cover
                        </p>

                        <div class="field-row">
                            <div class="field">
                                <label class="field-label">
                                    Pemerintah Kota / Kabupaten
                                </label>
                                <input class="input" value="PEMERINTAH KOTA BANJARMASIN" readonly>
                            </div>

                            <div class="field">
                                <label class="field-label">Dinas</label>
                                <input class="input" value="DINAS PENDIDIKAN" readonly>
                            </div>
                        </div>

                        <div class="school-field">
                            <label class="field-label">Nama Sekolah</label>
                            <input class="input" value="SMP NEGERI 15 BANJARMASIN" readonly>
                        </div>

                        <label class="field-label upload-label">
                            Logo sekolah / Tut Wuri Handayani
                        </label>

                        <div class="upload-box">
                            <div class="upload-inner">
                                <svg class="cloud-icon" viewBox="0 0 32 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 21H6.5C3.5 21 1.5 18.8 1.5 16
                                         C1.5 13.2 3.7 11 6.5 11
                                         C7.4 6.6 11 4 15.5 4
                                         C20.1 4 23.4 7 24 11
                                         C27.6 10.9 30 13.1 30 16.2
                                         C30 19 27.8 21 25 21H23" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16 26V13M11.5 17.5L16 13L20.5 17.5" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <div class="upload-title">Upload Logo</div>
                                <div class="upload-text">
                                    Klik untuk memilih file atau seret file ke sini
                                </div>
                                <div class="upload-text">
                                    Format PNG, JPG - Maksimal 5 MB
                                </div>
                            </div>
                        </div>

                        <p class="help-text">
                            Unggah logo resmi berformat PNG atau JPG untuk ditampilkan pada cover.
                        </p>

                        <div class="button-row">
                            <button class="save-button" type="button">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="main-footer">
                <span>© 2026 Jurnal Mengajar Guru</span>
                <span>V.01.00</span>
            </footer>
    </div>
</body>

</html>