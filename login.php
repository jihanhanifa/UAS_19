<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE username='$username'");
    $data = mysqli_fetch_array($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['nik'] = $data['nik'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = 'masyarakat';
        header("Location: dashboard_masyarakat.php");
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username'");
    $data = mysqli_fetch_array($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['id_petugas'] = $data['id_petugas'];
        $_SESSION['nama'] = $data['nama_petugas'];
        $_SESSION['level'] = $data['level'];
        $_SESSION['role'] = 'petugas';

        if ($data['level'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_petugas.php");
        }
        exit;
    }

    $error = "Username atau password salah.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Pengaduan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #1e3a8a, #3b82f6);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            max-width: 420px;
            margin: auto;
            margin-top: 80px;
            padding: 20px;
        }

        .card {
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 10px;
            background-color: #1e3a8a;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2542a1;
        }

        .logo {
            width: 64px;
            margin-bottom: 10px;
        }

        .title {
            font-weight: bold;
            color: #1e3a8a;
        }

        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        @media (max-width: 400px) { 
            .login-box {
                margin-top: 40px;
                padding: 10px;
            }

            .card {
                padding: 20px;
            }

            .logo {
                width: 48px;
            }

            .title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid"> 
    <div class="login-box">
        <div class="card text-center bg-white">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828490.png" class="logo" alt="Logo">
            <h4 class="title mb-3">Sistem Pengaduan Masyarakat</h4>
            <p class="mb-4 text-muted">Silakan login untuk melanjutkan</p>

            <?php if ($error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3 text-start">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="btn btn-outline-secondary">Belum punya akun? Daftar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
