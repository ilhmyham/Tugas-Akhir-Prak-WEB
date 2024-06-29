<?php
require_once "../config.php";

if (isset($_POST['submit'])) {
    $nama = $_POST['username'];
    $pass = md5($_POST['password']);
    $status = $_POST['status'];

    $sql = "INSERT INTO login(username, password, status) VALUES ('$nama', '$pass', '$status')";
    $data = mysqli_query($conn, $sql);

    if ($data) {
        header("Location: kelolaPengguna.php?status=sukses");
    } else {
        header("Location: kelolaPengguna.php?status=gagal");
    }
} else {
    die("akses dilarang...!!");
}
