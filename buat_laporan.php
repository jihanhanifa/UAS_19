<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_SESSION['nik'];
    $tgl_pengaduan = date('Y-m-d');
    $isi_laporan = mysqli_real_escape_string($koneksi, $_POST['isi_laporan']);
    $foto = '';

    if (!empty($_FILES['foto']['name'])) {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $path = time() . '_' . basename($nama_file);

        if (move_uploaded_file($tmp_file, $path)) {
            $foto = $path;
        }
    }

    $query = "INSERT INTO pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status) 
              VALUES ('$tgl_pengaduan', '$nik', '$isi_laporan', '$foto', '0')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard_masyarakat.php?status=berhasil");
        exit;
    } else {
        echo "Gagal menyimpan laporan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, rgb(116, 147, 169), #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0d47a1;
        }

        .btn-submit {
            background-color: #1976d2;
            border: none;
        }

        .btn-submit:hover {
            background-color: #0d47a1;
        }

        .btn-back:hover {
            background-color: #e3f2fd;
        }

        .form-label {
            font-weight: 600;
        }

        textarea {
            resize: vertical;
        }

        .icon-head {
            font-size: 2.5rem;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-chat-left-text-fill icon-head"></i>
                    <h2 class="form-title mt-2">Formulir Pengaduan</h2>
                    <p class="text-muted">Silakan isi detail laporan Anda di bawah ini.</p>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="isi_laporan" class="form-label">Isi Laporan</label>
                        <textarea name="isi_laporan" id="isi_laporan" rows="5" class="form-control" required placeholder="Contoh: Jalan berlubang di depan kantor desa..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Pendukung (opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="dashboard_masyarakat.php" class="btn btn-outline-secondary btn-back">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-submit text-white">
                            <i class="bi bi-send"></i> Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
