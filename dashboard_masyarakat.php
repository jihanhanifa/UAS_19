<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'masyarakat') {
    echo "<script>alert('Akses ditolak');location='login.php';</script>";
    exit;
}
$nik = $_SESSION['nik'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card-laporan:hover {
            background-color: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .btn-logout-fixed {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }
        @media (max-width: 576px) {
            h2, h3 {
                font-size: 1.25rem;
            }
            .card-body h6 {
                font-size: 0.9rem;
            }
            .table th, .table td {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="p-4 mb-4 text-white rounded shadow" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
        <h2 class="mb-1">Halo, <?= $_SESSION['nama'] ?> 👋</h2>
        <p class="mb-0">Selamat datang di Sistem Pengaduan Masyarakat</p>
    </div>

    <?php
    $total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE nik='$nik'"));
    $diproses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE nik='$nik' AND status='proses'"));
    $selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE nik='$nik' AND status='selesai'"));
    ?>
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body text-center">
                    <h6><i class="bi bi-bar-chart-fill"></i> Total Laporan</h6>
                    <h3><?= $total ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body text-center">
                    <h6><i class="bi bi-clock-fill"></i> Diproses</h6>
                    <h3><?= $diproses ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body text-center">
                    <h6><i class="bi bi-check-circle-fill"></i> Selesai</h6>
                    <h3><?= $selesai ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-journal-text"></i> Daftar Laporan Anda</h4>
        <a href="buat_laporan.php" class="btn btn-success"><i class="bi bi-pencil-square"></i> Buat Laporan</a>
    </div>

    <?php
    $query = mysqli_query($koneksi, "
        SELECT p.*, tg.tanggapan, tg.tgl_tanggapan
        FROM pengaduan p
        LEFT JOIN (
            SELECT t1.*
            FROM tanggapan t1
            JOIN (
                SELECT id_pengaduan, MAX(id_tanggapan) AS latest_id
                FROM tanggapan
                GROUP BY id_pengaduan
            ) t2 ON t1.id_tanggapan = t2.latest_id
        ) tg ON p.id_pengaduan = tg.id_pengaduan
        WHERE p.nik = '$nik'
        ORDER BY p.tgl_pengaduan DESC
    ");

    if (mysqli_num_rows($query) === 0) {
        echo "
        <div class='text-center my-5'>
            <img src='https://cdn-icons-png.flaticon.com/512/4076/4076549.png' width='150'>
            <h5 class='mt-3'>Belum ada laporan</h5>
            <p>Ayo sampaikan keluhan atau aspirasi Anda!</p>
            <a href='buat_laporan.php' class='btn btn-primary'>Buat Laporan Sekarang</a>
        </div>";
    } else {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover table-sm mt-3'>";
        echo "<thead class='table-light'>
                <tr>
                    <th><i class='bi bi-calendar-event'></i> Tanggal</th>
                    <th><i class='bi bi-file-earmark-text'></i> Isi Laporan</th>
                    <th><i class='bi bi-image'></i> Foto</th>
                    <th><i class='bi bi-info-circle'></i> Status</th>
                    <th><i class='bi bi-chat-left-dots'></i> Tanggapan</th>
                    <th><i class='bi bi-gear'></i> Aksi</th> <!-- Tambahan Kolom Aksi -->
                </tr>
              </thead>
              <tbody>";
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr class='card-laporan'>";
            echo "<td>{$row['tgl_pengaduan']}</td>";
            echo "<td>{$row['isi_laporan']}</td>";
            echo "<td>";
            if ($row['foto']) {
                echo "<img src='{$row['foto']}' width='100' class='img-thumbnail'>";
            } else {
                echo "<span class='text-muted'>Tidak ada foto</span>";
            }
            echo "</td>";
            echo "<td>";
            if ($row['status'] == '0') echo "<span class='badge bg-secondary'>Belum ditanggapi</span>";
            else if ($row['status'] == 'proses') echo "<span class='badge bg-warning text-dark'>Proses</span>";
            else if ($row['status'] == 'selesai') echo "<span class='badge bg-success'>Selesai</span>";
            else echo ucfirst($row['status']);
            echo "</td>";
            echo "<td>";
            if ($row['tanggapan']) {
                echo "<div><strong>{$row['tgl_tanggapan']}</strong><br>{$row['tanggapan']}</div>";
            } else {
                echo "<span class='text-muted fst-italic'>Belum ada tanggapan</span>";
            }
            echo "</td>";

            echo "<td>";
            if ($row['status'] == '0') {
                echo "<a href='edit_laporan.php?id={$row['id_pengaduan']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil-square'></i> Edit</a>";
            } else {
                echo "<span class='text-muted'>-</span>";
            }
            echo "</td>";

            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }
    ?>

    <a href="logout.php" class="btn btn-danger btn-logout-fixed d-sm-none">
        <i class="bi bi-box-arrow-left"></i> Logout
    </a>

    <div class="mt-4 d-none d-sm-block">
        <a href="logout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>
    </div>
</div>

</body>
</html>
