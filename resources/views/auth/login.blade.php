<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGURU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #2b2622; 
            --text-dark: #1a1a1a;
            --text-muted: #666;
            --bg-cream: #f8f6f3;
            --border-color: #e5e5e5;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        /* Lock layar agar tidak ada scroll di desktop */
        html, body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
        }

        .split-layout {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* --- KIRI (Gambar Full + Galeri Overlay) --- */
        .left-panel {
            flex: 1;
            position: relative;
            background-image: url('/images/sekolah.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: flex-end; /* Galeri menempel ke bawah */
            padding: 30px;
        }

        /* Overlay gelap tipis di bagian bawah agar galeri lebih menonjol */
        .left-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 40%);
            z-index: 1;
        }

        /* Galeri Foto Menimpa Gambar */
        .gallery-overlay {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 15px;
            width: 100%;
            max-width: 500px;
        }

        .gallery-item {
            flex: 1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            border: 2px solid rgba(255,255,255,0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 85px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        /* --- KANAN (Form Login) --- */
        .right-panel {
            flex: 1;
            background-color: var(--bg-cream);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2vh 5%;
            position: relative;
            overflow-y: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2vh;
        }

        .login-header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 1vh;
        }

        .login-header h2 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .divider {
            height: 1px;
            background-color: #d1d5db;
            width: 100%;
            margin: 2vh 0;
        }

        .welcome-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .welcome-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 2vh;
        }

        /* Form Input */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0 15px;
            height: 48px;
            margin-bottom: 2vh;
            background: #fff;
        }

        .input-group-custom:focus-within {
            border-color: #a0a0a0;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .input-group-custom i {
            color: #999;
            font-size: 16px;
            margin-right: 10px;
        }

        .input-group-custom input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: #333;
            background: transparent;
        }

        .password-toggle {
            background: none;
            border: none;
            color: #999;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background-color: var(--primary-dark);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 1vh;
            cursor: pointer;
        }

        .btn-submit:hover { background-color: #1a1614; }

        /* Info Box */
        .info-box {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 12px 15px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-top: 2.5vh;
            border: 1px solid #eaeaea;
        }

        .info-box i { font-size: 18px; color: #555; margin-top: 2px; }
        .info-box p { font-size: 11px; color: #555; line-height: 1.4; margin: 0; }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 992px) {
            html, body { overflow-y: auto; height: auto; }
            .split-layout { flex-direction: column; height: auto; }
            
            .left-panel { 
                min-height: 350px; 
                align-items: center; /* Galeri ke tengah di HP */
                padding: 20px;
            }
            
            .gallery-overlay {
                max-width: 100%;
            }

            .gallery-item img {
                height: 70px;
            }
            
            .right-panel { 
                padding: 40px 20px; 
            }
        }
    </style>
</head>
<body>

    <div class="split-layout">
        <!-- KIRI: Gambar Full + Galeri Overlay -->
        <div class="left-panel">
            <!-- Galeri 3 Gambar Menimpa Background -->
            <div class="gallery-overlay">
                <div class="gallery-item">
                    <img src="{{ asset('images/adwiyata.jpg') }}" alt="Program Adiwiyata">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/kepsek&wakasek.jpg') }}" alt="Kepala Sekolah & Wakil Kepala Sekolah">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/fotbar.jpg') }}" alt="Kebersamaan Warga Sekolah">
                </div>
            </div>
        </div>

        <!-- KANAN: Form Login -->
        <div class="right-panel">
            <div class="login-container">
                <div class="login-header">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo SIGURU">
                    <h2>SIGURU</h2>
                    <p>Sistem Informasi Jurnal Mengajar<br>Harian Guru</p>
                </div>

                <div class="divider"></div>

                <h3 class="welcome-title">Selamat Datang</h3>
                <p class="welcome-subtitle">Silakan masuk menggunakan akun yang telah terdaftar.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-3" role="alert" style="font-size: 12px; border-radius: 8px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person" aria-hidden="true"></i>
                        <input type="text" name="username" placeholder="Masukkan username"
                               value="{{ old('username') }}" autocomplete="username" required autofocus>
                    </div>

                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock" aria-hidden="true"></i>
                        <input id="login-password" type="password" name="password" placeholder="Masukkan password"
                               autocomplete="current-password" required>
                        <button class="password-toggle" type="button" id="toggle-password"
                                aria-label="Tampilkan password" title="Tampilkan/sembunyikan password">
                            <i class="bi bi-eye-slash" aria-hidden="true"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk ke SIGURU
                    </button>
                </form>

                <div class="info-box">
                    <i class="bi bi-shield-check"></i>
                    <p>Gunakan akun yang diberikan oleh administrator.<br>Jaga kerahasiaan username dan password Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT TETAP UTUH -->
    <script>
        const passwordInput = document.getElementById('login-password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            this.innerHTML = isPassword
                ? '<i class="bi bi-eye" aria-hidden="true"></i>'
                : '<i class="bi bi-eye-slash" aria-hidden="true"></i>';
            this.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>
</html>