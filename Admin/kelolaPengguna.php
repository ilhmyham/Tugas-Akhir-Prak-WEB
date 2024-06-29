<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['username']) || $_SESSION['status'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        echo "<script>
    alert('data berhasil ditambahkan')
</script>";
    } elseif ($_GET['status'] == 'suksesUpdate') {
        echo "<script>
    alert('data berhasil dirubah')
</script>";
    } elseif ($_GET['status'] == 'gagalUpdate') {
        echo "<script>
    alert('data gagal dirubah')
</script>";
    } else {
        echo "<script>
    alert('data gagal ditambahkan')
</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obatin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../css/admin.css">
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
                <a class="nav-link  active btn btn-primary" href="kelolaPengguna.php"><i class="fa-regular fa-user"></i> kelola pengguna</a>
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

    <div class="content">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Table</li>
            </ol>
        </nav>

        <div class="table-responsive">
            <div class="txt-brand">
                <h3>Tabel user</h3>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah User
            </button>
            <table class="table table-striped" id="mytable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>username</th>
                        <th>password</th>
                        <th>status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = "SELECT * from login";
                    $sql = mysqli_query($conn, $query);
                    foreach ($sql as $val) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $val['username']; ?></td>
                            <td><?php echo $val['password']; ?></td>
                            <td><?php echo $val['status']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal2<?php echo $val['id'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $val['id'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <!-- Modal -->
                                <?php include "deleteModalUser.php"; ?>
                                <!-- <a href="" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a> -->
                            </td>
                        </tr>
                        <!-- Tambahkan baris sesuai kebutuhan -->
                    <?php
                        include "editmodaluser.php";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <?php include "createmodaluser.php"; ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            $('#mytable').DataTable();
        });
    </script>
</body>

</html>