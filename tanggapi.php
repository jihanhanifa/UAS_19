<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Silakan login terlebih dahulu');location='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID pengaduan tidak ditemukan');location='dashboard_admin.php';</script>";
    exit;
}

$id_pengaduan = $_GET['id'];

$query_pengaduan = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");
$data_pengaduan = mysqli_fetch_assoc($query_pengaduan);

if (!$data_pengaduan) {
    echo "<script>alert('Data pengaduan tidak ditemukan');location='dashboard_admin.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggapan = htmlspecialchars($_POST['tanggapan']);
    $status = $_POST['status'];

    $insert = mysqli_query($koneksi, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('$id_pengaduan', NOW(), '$tanggapan', NULL)");
    $update_status = mysqli_query($koneksi, "UPDATE pengaduan SET status='$status' WHERE id_pengaduan='$id_pengaduan'");

    if ($insert && $update_status) {
        echo "<script>alert('Tanggapan berhasil dikirim');location='dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim tanggapan');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Tanggapan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .card-header {
            background: linear-gradient(45deg,rgb(61, 104, 168), #0a58ca);
            color: white;
            border-radius: 12px 12px 0 0;
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .btn-success {
            background-color: #198754;
            border: none;
        }
        .btn-success:hover {
            background-color: #157347;
        }
        .btn-outline-secondary:hover {
            background-color: #e9ecef;
        }
        .section-title {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <h3 class="mb-4 text-center"><i class="bi bi-chat-dots"></i> Tanggapi Pengaduan</h3>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-file-earmark-text"></i> Data Pengaduan
        </div>
        <div class="card-body">
            <div class="mb-2"><strong>NIK:</strong> <?= $data_pengaduan['nik']; ?></div>
            <div class="mb-2"><strong>Tanggal Pengaduan:</strong> <?= $data_pengaduan['tgl_pengaduan']; ?></div>
            <div class="mb-2">
                <strong>Status Saat Ini:</strong>
                <span class="badge <?= ($data_pengaduan['status'] == 'selesai') ? 'bg-success' : 'bg-warning text-dark' ?>">
                    <?= ucfirst($data_pengaduan['status']); ?>
                </span>
            </div>
            <div class="mb-2"><strong>Isi Laporan:</strong><br><?= nl2br(htmlspecialchars($data_pengaduan['isi_laporan'])); ?></div>
            <?php if ($data_pengaduan['foto']) : ?>
                <div class="mt-3">
                    <strong>Foto Bukti:</strong><br>
                    <img src="uploads/<?= $data_pengaduan['foto']; ?>" width="250" class="img-fluid rounded border shadow-sm">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card p-4">
        <div class="section-title"><i class="bi bi-pencil-square"></i> Form Tanggapan</div>
        <form method="post">
            <div class="mb-3">
                <label for="tanggapan" class="form-label">Tanggapan:</label>
                <textarea name="tanggapan" id="tanggapan" rows="4" class="form-control" required placeholder="Tulis tanggapan Anda di sini..."></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Pengaduan:</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="dashboard_admin.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-send-check-fill"></i> Kirim Tanggapan
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
