<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $telp = $_POST['telp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE nik='$nik'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIK sudah terdaftar!');location='register.php';</script>";
    } else {
        $simpan = mysqli_query($koneksi, "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES ('$nik', '$nama', '$username', '$password', '$telp')");
        if ($simpan) {
            echo "<script>alert('Registrasi berhasil!');location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f4f9;
        }

        .wrapper {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .left-box, .right-box {
            padding: 40px 30px;
        }

        .left-box {
            background: linear-gradient(135deg, #1e88e5, #1565c0);
            color: white;
        }

        .left-box i {
            font-size: 3rem;
        }

        @media (max-width: 767px) {
            .left-box {
                text-align: center;
                border-radius: 15px 15px 0 0;
            }

            .right-box {
                border-radius: 0 0 15px 15px;
            }
        }

        @media (min-width: 768px) {
            .row-flex {
                display: flex;
                align-items: stretch;
                justify-content: center;
            }

            .left-box {
                border-radius: 15px 0 0 15px;
                flex: 1;
            }

            .right-box {
                border-radius: 0 15px 15px 0;
                flex: 1;
                background: #fff;
            }
        }
    </style>
</head>
<body>

<div class="py-5">
    <div class="wrapper row-flex">
        <div class="left-box d-flex flex-column justify-content-center">
            <div>
                <i class="bi bi-megaphone-fill mb-3"></i>
                <h2>Pengaduan Masyarakat</h2>
                <p class="mb-0">Laporkan aspirasi atau keluhan Anda langsung lewat sistem ini.</p>
            </div>
        </div>

        <div class="right-box">
            <h4 class="mb-4 text-center">Daftar Akun</h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" required maxlength="16">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" id="nama" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="telp" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" name="telp" id="telp" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Daftar</button>
                <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
