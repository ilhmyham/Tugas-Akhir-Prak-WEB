<?php
require_once "../config.php";
$id = $_POST['id'];
$sql = "DELETE FROM obat WHERE id_obat = $id";
$data = mysqli_query($conn, $sql);

if ($data) {
    echo "<script>
        alert('data berhasil dihapus');
        document.location='tabelobat.php';
    </script>";
} else {
    echo "<script>
        alert('data gagal dihapus');
        document.location='tabelobat.php';
    </script>";
}
