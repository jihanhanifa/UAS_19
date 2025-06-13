<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Sistem Pengaduan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .hero-icon {
            font-size: 3rem;
            color: #1976d2;
            margin-bottom: 20px;
        }
        .btn-lg i {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="hero-card">
        <i class="bi bi-megaphone-fill hero-icon"></i>
        <h1 class="mb-3">Sistem Pengaduan Masyarakat</h1>
        <p class="lead text-muted mb-4">
            Laporkan keluhan atau masalah di lingkungan Anda secara cepat, aman, dan mudah!
        </p>
        <div class="d-grid gap-3 d-sm-flex justify-content-center">
            <a href="login.php" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            <a href="register.php" class="btn btn-success btn-lg">
                <i class="bi bi-person-plus-fill"></i> Daftar
            </a>
        </div>
    </div>
</body>
</html>
