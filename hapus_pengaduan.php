<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Akses ditolak');location='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID pengaduan tidak ditemukan');location='dashboard_admin.php';</script>";
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM tanggapan WHERE id_pengaduan='$id'");

$query = mysqli_query($koneksi, "DELETE FROM pengaduan WHERE id_pengaduan='$id'");

if ($query) {
    echo "<script>alert('Data pengaduan berhasil dihapus');location='dashboard_admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data');location='dashboard_admin.php';</script>";
}
?>
