<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        echo "<script>alert('data berhasil ditambahkan')</script>";
    } elseif ($_GET['status'] == 'suksesUpdate') {
        echo "<script>alert('data berhasil dirubah')</script>";
    } elseif ($_GET['status'] == 'gagalUpdate') {
        echo "<script>alert('data gagal dirubah')</script>";
    } else {
        echo "<script>alert('data gagal ditambahkan')</script>";
    }
}

// Mengambil total jumlah obat yang terjual hari ini
$date_today = date('Y-m-d');
$query_total_sold = "SELECT SUM(jumlah) as total_sold FROM transaksi WHERE DATE(tanggal) = '$date_today'";
$result_total_sold = mysqli_query($conn, $query_total_sold);
$total_sold = mysqli_fetch_assoc($result_total_sold)['total_sold'];

// Mengambil total jumlah obat yang berada di gudang
$query_total_stock = "SELECT SUM(stock) as total_stock FROM obat";
$result_total_stock = mysqli_query($conn, $query_total_stock);
$total_stock = mysqli_fetch_assoc($result_total_stock)['total_stock'];

// Mengambil total pendapatan harian
$query_total_income = "SELECT SUM(total_harga) as total_income FROM transaksi WHERE DATE(tanggal) = '$date_today'";
$result_total_income = mysqli_query($conn, $query_total_income);
$total_income = mysqli_fetch_assoc($result_total_income)['total_income'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obatin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/ngadmin.css">
    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-bottom fixed-top navbar-light bg-dark p-2">
        <a class="navbar-brand text-light" href="#">Obatin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-danger" href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="sidebar">
        <center>
            <h4 class="menu-title">Menu</h4>
        </center>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active btn btn-primary" href="dashboardUser.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn" href="transaksi.php"><i class="fa-regular fa-handshake"></i> Transaksi</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-file-alt"></i> Laporan
                </a>
                <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
                    <li><a class="dropdown-item" href="laporanTransaksi.php">Laporan Transaksi</a></li>
                    <li><a class="dropdown-item" href="laporanObat.php">Laporan Obat</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="content" style="margin-left: 260px; padding: 20px;">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard User</li>
            </ol>
        </nav>

        <!-- Dashboard Cards -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Total Obat Terjual Hari Ini</div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $total_sold ? $total_sold : 0; ?> Obat</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Total Obat di Gudang</div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $total_stock ? $total_stock : 0; ?> Obat</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Total Pendapatan Hari Ini</div>
                        <div class="card-body">
                            <h5 class="card-title">Rp. <?= $total_income ? number_format($total_income, 2, ',', '.') : '0,00'; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>