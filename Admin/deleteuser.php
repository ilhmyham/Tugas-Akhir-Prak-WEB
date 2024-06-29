<?php
require_once "../config.php";
$id = $_POST['id'];
$sql = "DELETE FROM login WHERE id = $id";
$data = mysqli_query($conn, $sql);

if ($data) {
    echo "<script>
        alert('data berhasil dihapus');
        document.location='kelolaPengguna.php';
    </script>";
} else {
    echo "<script>
        alert('data gagal dihapus');
        document.location='kelolaPengguna.php';
    </script>";
}
