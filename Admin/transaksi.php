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

// Fetching barang data
$barang = [];
$result = mysqli_query($conn, "SELECT id_obat, nama_obat, harga FROM obat");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $barang[] = $row;
    }
}

// Check if today is a new day and reset transaksi table if necessary
$date_today = date('Y-m-d');
$result = mysqli_query($conn, "SELECT * FROM transaksi WHERE DATE(tanggal) = '$date_today'");
if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "DELETE FROM transaksi WHERE DATE(tanggal) < '$date_today'");
}

// Fetching transaksi data
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
    <title>Obatin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- css -->
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
                <a class="nav-link active btn btn-primary" href="transaksi.php"><i class="fa-regular fa-handshake"></i> Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn" href="kelolaPengguna.php"><i class="fa-regular fa-user"></i> kelola pengguna</a>
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


    <div class="content p-4">
        <!-- Form Transaksi -->
        <div class="card mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    Tambah Transaksi
                </div>
                <div class="card-body">
                    <form id="transaksiForm" action="proses_tambah_transaksi.php" method="POST">
                        <div id="transaksi-form">
                            <div class="mb-3 row" id="transaksi-row">
                                <div class="col-md-5">
                                    <label for="id_barang" class="form-label">Nama Obat</label>
                                    <select class="form-control" id="id_barang" name="id_barang[]" required>
                                        <option value="" disabled selected>Pilih Obat</option>
                                        <?php foreach ($barang as $b) : ?>
                                            <option value="<?= $b['id_obat']; ?>" data-harga="<?= $b['harga']; ?>"><?= $b['nama_obat']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah[]" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input type="number" class="form-control" id="total_harga" name="total_harga[]" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Aksi</label>
                                    <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-add"><i class="fas fa-plus"></i> Tambah Obat</button>
                        <hr>
                        <div class="mb-3">
                            <label for="total_belanja" class="form-label">Total Belanja</label>
                            <input type="number" class="form-control" id="total_belanja" name="total_belanja" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="uang_bayar" class="form-label">Uang Bayar</label>
                            <input type="number" class="form-control" id="uang_bayar" name="uang_bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="kembalian" class="form-label">Kembalian</label>
                            <input type="number" class="form-control" id="kembalian" name="kembalian" readonly>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-arrow-right"></i> Kirim</button>
                        <button type="button" class="btn btn-primary" id="btnPrint"><i class="fas fa-print"></i> Cetak Struk</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Tabel Transaksi -->
        <div class="card">
            <div class="card-header">
                Daftar Transaksi
            </div>
            <div class="card-body">
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
                                <td><?= $t['id_transaksi']; ?></td>
                                <td><?= $t['tanggal']; ?></td>
                                <td><?= $t['nama_obat']; ?></td>
                                <td><?= $t['jumlah']; ?></td>
                                <td><?= $t['total_harga']; ?></td>
                                <td><?= $t['username']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
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

            function updateTotal() {
                var totalBelanja = 0;
                $('#transaksi-form .row').each(function() {
                    var harga = $(this).find('select option:selected').data('harga');
                    var jumlah = $(this).find('input[name="jumlah[]"]').val();
                    var total = harga * jumlah;
                    $(this).find('input[name="total_harga[]"]').val(total);
                    totalBelanja += total;
                });
                $('#total_belanja').val(totalBelanja);
                updateKembalian();
                checkRemoveButton();
            }

            function updateKembalian() {
                var totalBelanja = parseFloat($('#total_belanja').val()) || 0;
                var uangBayar = parseFloat($('#uang_bayar').val()) || 0;
                var kembalian = uangBayar - totalBelanja;
                $('#kembalian').val(kembalian);
            }

            function checkRemoveButton() {
                var rowCount = $('#transaksi-form .row').length;
                if (rowCount === 1) {
                    $('#transaksi-form .btn-remove').hide();
                } else {
                    $('#transaksi-form .btn-remove').show();
                }
            }

            $(document).on('change', '#transaksi-form', '#id_barang, #jumlah', function() {
                updateTotal();
            });

            $('#uang_bayar').on('input', function() {
                updateKembalian();
            });

            $('.btn-add').click(function() {
                var newRow = $('#transaksi-row').clone().removeAttr('id');
                newRow.find('input').val('');
                $('#transaksi-form').append(newRow);
                updateTotal();
            });

            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.row').remove();
                updateTotal();
            });

            $('#btnPrint').click(function() {
                var strukContent = `
                <h3>Struk Pembayaran</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
                $('#transaksi-form .row').each(function() {
                    var namaObat = $(this).find('select option:selected').text();
                    var jumlah = $(this).find('input[name="jumlah[]"]').val();
                    var harga = $(this).find('select option:selected').data('harga');
                    var total = harga * jumlah;
                    strukContent += `
                    <tr>
                        <td>${namaObat}</td>
                        <td>${jumlah}</td>
                        <td>${harga}</td>
                        <td>${total}</td>
                    </tr>
                `;
                });
                strukContent += `
                    </tbody>
                </table>
                <p>Total Belanja: ${$('#total_belanja').val()}</p>
                <p>Uang Bayar: ${$('#uang_bayar').val()}</p>
                <p>Kembalian: ${$('#kembalian').val()}</p>
            `;
                var newWindow = window.open('', '', 'width=600,height=400');
                newWindow.document.write(strukContent);
                newWindow.print();
            });

            checkRemoveButton();
        });
    </script>


</body>

</html>