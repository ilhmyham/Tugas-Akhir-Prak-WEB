<?php
require_once "../config.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['user'];
    $pass = md5($_POST['password']);
    $status = $_POST['status'];

    $sql = "UPDATE login Set username='$nama', password='$pass', status='$status' WHERE id='$id'";
    $val = mysqli_query($conn, $sql);

    if ($val) {
        header("Location: kelolaPengguna.php?status=suksesUpdate");
    } else {
        header("Location: kelolaPengguna.php?status=gagalUpdate");
    }
} else {
    die("Akses dilarang");
}
