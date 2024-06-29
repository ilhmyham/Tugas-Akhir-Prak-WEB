<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$date_today = date('Y-m-d');
$transaksi = [];
$result = mysqli_query($conn, "SELECT t.id_transaksi, t.tanggal, b.nama_obat, t.jumlah, t.total_harga, u.username FROM transaksi t JOIN obat b ON t.id_obat = b.id_obat JOIN login u ON t.id_pengguna = u.id WHERE DATE(t.tanggal) = '$date_today'");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $transaksi[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laporan Transaksi</title>
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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
                <a class="nav-link btn" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn" href="tabelobat.php"><i class="fa-solid fa-capsules"></i> Obat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn" href="transaksi.php"><i class="fa-regular fa-handshake"></i> Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn" href="kelolaPengguna.php"><i class="fa-regular fa-user"></i> kelola pengguna</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link active btn btn-primary dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <li class="breadcrumb-item active" aria-current="page">Data Table</li>
            </ol>
        </nav>

        <!-- Dashboard Cards -->
        <div class="container">
            <h4>Transaksi</h4>
            <div class="data-tables datatable-dark">
                <table id="mytable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Kasir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $t) : ?>
                            <tr>
                                <td><?php echo $t['id_transaksi']; ?></td>
                                <td><?php echo $t['tanggal']; ?></td>
                                <td><?php echo $t['nama_obat']; ?></td>
                                <td><?php echo $t['jumlah']; ?></td>
                                <td><?php echo $t['total_harga']; ?></td>
                                <td><?php echo $t['username']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

</body>

</html>