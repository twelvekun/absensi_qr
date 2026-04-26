<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi SMP Hasyim Asy'ari</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            /* Nuansa gradient hijau sekolah */
            background: linear-gradient(135deg, #1e5631 0%, #4c9a2a 100%); 
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            display: flex;
            max-width: 850px;
            width: 100%;
            margin: 20px;
        }
        /* Bagian kiri untuk gambar ilustrasi/sekolah */
        .login-left {
            /* Menggunakan gambar ilustrasi gedung sekolah dari Unsplash sebagai contoh */
            background: url('assets/img/login-left.jpeg') center/cover;
            width: 50%;
            position: relative;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(30, 86, 49, 0.75); /* Overlay hijau transparan */
        }
        .login-left-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
            color: white;
            padding-right: 20px;
        }
        .login-left-content h2 { margin: 0; font-size: 26px; line-height: 1.3; }
        .login-left-content p { margin: 10px 0 0; font-size: 14px; opacity: 0.9; }
        
        /* Bagian kanan untuk form login */
        .login-right {
            width: 50%;
            padding: 50px 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .school-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .school-logo-placeholder {
            width: 70px;
            height: 70px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #1e5631;
            font-weight: bold;
            font-size: 24px;
            border: 2px solid #4c9a2a;
        }
        .login-right h3 {
            margin: 0 0 5px;
            color: #333;
            text-align: center;
            font-weight: 600;
        }
        .login-right p {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: #555;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #4c9a2a;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 154, 42, 0.2);
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #1e5631;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            font-family: 'Poppins', sans-serif;
            margin-top: 10px;
        }
        .btn-login:hover {
            background-color: #143d22;
        }
        .btn-login:active {
            transform: scale(0.98);
        }
        .alert {
            color: #842029;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: center;
            font-weight: 500;
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { width: 100%; padding: 40px 30px; }
            .login-wrapper { max-width: 400px; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-left">
            <div class="login-left-content">
                <h2>Sistem Absensi Digital QR Code</h2>
                <p>Menggunakan Algoritma Reed-Solomon untuk pembacaan data yang cepat, akurat, dan toleran terhadap kerusakan kode.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="school-logo">
               <img src="<?= base_url('assets/img/logo-sekolah.jpeg') ?>" alt="Logo Sekolah" style="width: 80px;">
            </div>
            <h3>Selamat Datang</h3>
            <p>Sistem Absensi SMP Hasyim Asy'ari Glagah</p>
            
            <?php if(session()->getFlashdata('msg')):?>
                <div class="alert"><?= session()->getFlashdata('msg') ?></div>
            <?php endif;?>

            <form action="<?= base_url('auth/process') ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username Admin/TU" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" class="btn-login">Masuk ke Sistem</button>
            </form>
        </div>
    </div>

</body>
</html>