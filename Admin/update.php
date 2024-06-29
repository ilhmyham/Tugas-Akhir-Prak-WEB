<?php
require_once "../config.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['obat'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gudang = $_POST['gudang'];

    $sql = "UPDATE obat Set nama_obat='$nama', deskripsi='$deskripsi', stock='$stok', harga='$harga', id_gudang='$gudang' WHERE id_obat='$id'";
    $val = mysqli_query($conn, $sql);

    if ($val) {
        header("Location: tabelobat.php?status=suksesUpdate");
    } else {
        header("Location: tabelobat.php?status=gagalUpdate");
    }
} else {
    die("Akses dilarang");
}
