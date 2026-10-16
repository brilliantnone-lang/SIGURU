<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGURU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --school-green: #0a4c2e;
            --school-green-button: #084b2d;
            --school-text: #173d2b;
        }

        * { box-sizing: border-box; }

        html, body { min-height: 100%; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--school-text);
            background: #fff;
            border-top: 3px solid #292929;
            border-bottom: 3px solid #292929;
            overflow-x: hidden;
        }

        .school-header {
            height: 64px;
            padding: 0 2.6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #fff;
            position: relative;
            z-index: 5;
        }

        .school-brand {
            display: flex;
            align-items: center;
            gap: 17px;
            min-width: 0;
        }

        .school-brand img {
            width: 40px;
            height: 44px;
            object-fit: contain;
            flex: 0 0 auto;
        }

        .school-brand-name {
            margin: 0;
            font-size: 14px;
            line-height: 1.2;
            font-weight: 700;
            color: #123d2a;
            white-space: nowrap;
        }

        .login-scene {
            /* Rasio area dibuat mendekati screenshot referensi pada layar desktop. */
            height: min(56.5vw, 518px);
            min-height: 470px;
            max-height: 620px;
            position: relative;
            background-image: url('/images/sekolah.jpg');
            /* Foto tetap proporsional; titik fokus dinaikkan agar papan tidak terlalu dominan. */
            background-size: cover;
            background-position: center 43%;
            background-repeat: no-repeat;
        }

        .login-scene::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0,0,0,.04), rgba(0,0,0,.03));
            pointer-events: none;
        }

        .login-card {
            position: absolute;
            z-index: 2;
            top: 10.2%;
            right: 1.3%;
            width: clamp(242px, 14.8vw, 270px);
            min-height: 428px;
            padding: 25px 30px 27px;
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 7px;
            background: rgba(255,255,255,.91);
            box-shadow: 0 3px 14px rgba(0,0,0,.10);
        }

        .login-logo {
            display: block;
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin: 0 auto 10px;
        }

        .login-school-name {
            margin: 0;
            text-align: center;
            color: #123d2a;
            font-size: 13px;
            line-height: 1.35;
            font-weight: 700;
        }

        .login-school-city {
            margin: 3px 0 0;
            text-align: center;
            font-size: 8px;
            color: #294b3b;
            letter-spacing: .2px;
        }

        .login-divider {
            width: 45px;
            height: 1px;
            margin: 9px auto 22px;
            background: #c8d5cd;
        }

        .login-heading {
            margin: 0 0 3px;
            color: #123d2a;
            text-align: center;
            font-size: 10px;
            line-height: 1.3;
            font-weight: 700;
        }

        .login-description {
            margin: 0 auto 25px;
            max-width: 175px;
            color: #294b3b;
            text-align: center;
            font-size: 8px;
            line-height: 1.35;
        }

        .login-field {
            height: 33px;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 11px;
            border: 1px solid #dce4df;
            border-radius: 7px;
            background: #fff;
        }

        .login-field > i {
            flex: 0 0 auto;
            color: #8b9690;
            font-size: 12px;
        }

        .login-field input {
            width: 100%;
            min-width: 0;
            height: 100%;
            padding: 0;
            border: 0;
            outline: 0;
            background: transparent;
            color: #244535;
            font-size: 9px;
            box-shadow: none;
        }

        .login-field input::placeholder { color: #8295a7; opacity: 1; }

        .password-toggle {
            border: 0;
            padding: 0;
            background: transparent;
            color: #8b9690;
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 12px;
        }

        .login-submit {
            width: 100%;
            height: 35px;
            margin-top: 15px;
            border: 1px solid var(--school-green-button);
            border-radius: 6px;
            background: var(--school-green-button);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
        }

        .login-submit:hover,
        .login-submit:focus {
            background: #063d25;
            border-color: #063d25;
            color: #fff;
        }

        .school-gallery {
            position: absolute;
            z-index: 3;
            left: 2%;
            bottom: -53px;
            display: flex;
            gap: clamp(12px, 2.1vw, 20px);
            align-items: flex-start;
        }

        .school-gallery img {
            display: block;
            width: clamp(150px, 20.8vw, 190px);
            height: 108px;
            object-fit: cover;
            border: 1px solid rgba(255,255,255,.8);
            border-radius: 7px;
            box-shadow: 0 2px 5px rgba(0,0,0,.08);
        }

        .school-footer {
            height: 70px;
            background: #fff;
        }

        @media (max-width: 700px) {
            .school-header {
                height: auto;
                min-height: 64px;
                padding: 10px 16px;
                align-items: flex-start;
                flex-direction: column;
                gap: 7px;
            }

            .school-brand { gap: 10px; }
            .school-brand img { width: 34px; height: 38px; }
            .school-brand-name { font-size: 12px; white-space: normal; }
            .school-motto { gap: 7px; font-size: 7px; flex-wrap: wrap; }
            .school-motto span + span { padding-left: 7px; }

            .login-scene {
                height: auto;
                min-height: 770px;
                background-position: center 43%;
                background-size: auto 430px;
                background-color: #fff;
            }

            .login-card {
                top: 30px;
                right: 50%;
                transform: translateX(50%);
                width: min(290px, calc(100% - 32px));
                min-height: 428px;
            }

            .school-gallery {
                left: 12px;
                right: 12px;
                bottom: 15px;
                gap: 8px;
                justify-content: center;
            }

            .school-gallery img {
                width: calc((100% - 16px) / 3);
                height: 75px;
                border-radius: 5px;
            }

            .school-footer { height: 10px; }
        }

        @media (max-width: 360px) {
            .school-motto { white-space: normal; }
            .school-gallery img { height: 62px; }
        }
    </style>
</head>
<body>
    <header class="school-header">
        <div class="school-brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo SMP Negeri 15 Banjarmasin">
            <h1 class="school-brand-name">SMP NEGERI 15 BANJARMASIN</h1>
        </div>

    </header>

    <main class="login-scene">
        <section class="login-card" aria-label="Form login SIGURU">
            <img class="login-logo" src="{{ asset('images/logo.jpg') }}" alt="Logo sekolah">

            <h2 class="login-school-name">SMP NEGERI 15</h2>
            <p class="login-school-city">BANJARMASIN</p>
            <div class="login-divider"></div>

            <h3 class="login-heading">JURNAL MENGAJAR</h3>
            <p class="login-description">Sistem Informasi Jurnal Mengajar Guru<br>&amp; Presensi Siswa</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-2 mb-2" role="alert" style="font-size: 10px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label class="login-field">
                    <i class="bi bi-person" aria-hidden="true"></i>
                    <input type="text" name="username" placeholder="Username"
                           value="{{ old('username') }}" autocomplete="username" required autofocus>
                </label>

                <label class="login-field">
                    <i class="bi bi-lock" aria-hidden="true"></i>
                    <input id="login-password" type="password" name="password" placeholder="Password"
                           autocomplete="current-password" required>
                    <button class="password-toggle" type="button" id="toggle-password"
                            aria-label="Tampilkan password" title="Tampilkan/sembunyikan password">
                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                    </button>
                </label>

                <button type="submit" class="btn login-submit">Masuk</button>
            </form>
        </section>

        <div class="school-gallery" aria-label="Foto kegiatan dan sekolah">
            <img src="{{ asset('images/adwiyata.jpg') }}" alt="Kegiatan Adiwiyata">
            <img src="{{ asset('images/kepsek&wakasek.jpg') }}" alt="Kepala sekolah dan wakil kepala sekolah">
            <img src="{{ asset('images/fotbar.jpg') }}" alt="Foto bersama warga sekolah">
        </div>
    </main>

    <footer class="school-footer"></footer>

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
