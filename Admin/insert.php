<?php
require_once "../config.php";

if (isset($_POST['submit'])) {
    $nama = $_POST['obat'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $gudang = $_POST['gudang'];

    $sql = "INSERT INTO obat(nama_obat, deskripsi, stock, harga, id_gudang) VALUES ('$nama', '$deskripsi', '$stok', '$harga', '$gudang')";
    $data = mysqli_query($conn, $sql);

    if ($data) {
        header("Location: tabelobat.php?status=sukses");
    } else {
        header("Location: tabelobat.php?status=gagal");
    }
} else {
    die("akses dilarang...!!");
}
