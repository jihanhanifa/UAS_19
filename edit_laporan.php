<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'masyarakat') {
    echo "<script>alert('Akses ditolak');location='login.php';</script>";
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID pengaduan tidak ditemukan');location='dashboard_masyarakat.php';</script>";
    exit;
}

$id = $_GET['id'];
$nik = $_SESSION['nik'];

$stmt = mysqli_prepare($koneksi, "SELECT * FROM pengaduan WHERE id_pengaduan = ? AND nik = ?");
mysqli_stmt_bind_param($stmt, "is", $id, $nik);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data || $data['status'] !== '0') {
    echo "<script>alert('Laporan tidak dapat diedit.');location='dashboard_masyarakat.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isi_laporan = mysqli_real_escape_string($koneksi, $_POST['isi_laporan']);

    $update_stmt = mysqli_prepare($koneksi, "UPDATE pengaduan SET isi_laporan = ? WHERE id_pengaduan = ?");
    mysqli_stmt_bind_param($update_stmt, "si", $isi_laporan, $id);
    mysqli_stmt_execute($update_stmt);

    echo "<script>alert('Laporan berhasil diperbarui');location='dashboard_masyarakat.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Edit Laporan</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="isi_laporan" class="form-label">Isi Laporan</label>
            <textarea class="form-control" name="isi_laporan" rows="5" required><?= htmlspecialchars($data['isi_laporan']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="dashboard_masyarakat.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
