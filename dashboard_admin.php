<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Silakan login terlebih dahulu');location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            width: 220px;
            background-color: rgb(57, 96, 155);
            color: white;
            padding: 1.5rem 1rem;
        }

        .sidebar h4 {
            margin-bottom: 2rem;
        }

        .btn-sidebar {
            background-color: transparent;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            width: 100%;
            text-align: left;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-sidebar:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateX(3px);
        }

        .btn-sidebar.active {
            background-color: rgba(255,255,255,0.3);
        }

        .card-header {
            background-color: rgb(57, 96, 155);
            color: white;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .status-belum {
            color: orange;
            font-weight: bold;
        }

        .status-proses {
            color: blue;
            font-weight: bold;
        }

        .status-selesai {
            color: green;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                left: -100%;
                top: 0;
                height: 100%;
                width: 220px;
                transition: left 0.3s ease-in-out;
            }

            .sidebar.show {
                left: 0;
            }

            #toggleSidebar {
                display: inline-block;
                margin-bottom: 20px;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100vw;
                background: rgba(0,0,0,0.5);
                z-index: 900;
                display: none;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="d-flex">
    <div class="sidebar" id="sidebar">
        <h4>🛠️ Pengaduan Masyarakat</h4>
        <p>👋 Halo, <strong><?= $_SESSION['nama']; ?></strong></p>
        <a href="dashboard_admin.php" class="btn btn-sidebar active">📋 Dashboard</a>
        <a href="logout.php" class="btn btn-sidebar text-danger">🚪 Logout</a>
    </div>

    <div class="flex-grow-1 p-4">
        <button class="btn btn-outline-primary d-md-none mb-3" id="toggleSidebar">☰ Menu</button>

        <h2 class="mb-4">Dashboard Admin</h2>

        <div class="card shadow-sm">
            <div class="card-header">Daftar Pengaduan</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM pengaduan ORDER BY tgl_pengaduan DESC");
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>{$row['tgl_pengaduan']}</td>";
                            echo "<td>{$row['nik']}</td>";
                            echo "<td>{$row['isi_laporan']}</td>";
                            echo "<td>";
                            if (!empty($row['foto'])) {
                                echo "<img src='{$row['foto']}' width='100' class='img-thumbnail'>";
                            } else {
                                echo "<span class='text-muted'>Tidak ada foto</span>";
                            }
                            echo "</td>";
                            echo "<td>";
                            if ($row['status'] == '0') {
                                echo "<span class='status-belum'>Belum ditanggapi</span>";
                            } elseif ($row['status'] == 'proses') {
                                echo "<span class='status-proses'>Proses</span>";
                            } elseif ($row['status'] == 'selesai') {
                                echo "<span class='status-selesai'>Selesai</span>";
                            } else {
                                echo htmlspecialchars($row['status']);
                            }
                            echo "</td>";
                            echo "<td>";
                            if ($row['status'] == 'selesai') {
                                echo "<button class='btn btn-sm btn-secondary mb-1' disabled>Sudah Ditanggapi</button><br>";
                            } else {
                                echo "<a href='tanggapi.php?id={$row['id_pengaduan']}' class='btn btn-sm btn-primary mb-1'>Tanggapi</a><br>";
                            }
                            echo "<a href='hapus_pengaduan.php?id={$row['id_pengaduan']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus pengaduan ini?')\">Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('overlay').classList.toggle('show');
    }
</script>
</body>
</html>
