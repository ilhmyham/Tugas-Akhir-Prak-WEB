<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$id_pengguna = $_SESSION['id_pengguna'];
$id_barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$total_harga = $_POST['total_harga'];
$tanggal = date('Y-m-d H:i:s'); // Mendapatkan tanggal saat ini

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
    for ($i = 0; $i < count($id_barang); $i++) {
        // Cek stok obat
        $query_check_stock = "SELECT stock FROM obat WHERE id_obat = ?";
        $stmt_check_stock = mysqli_prepare($conn, $query_check_stock);
        mysqli_stmt_bind_param($stmt_check_stock, 'i', $id_barang[$i]);
        mysqli_stmt_execute($stmt_check_stock);
        mysqli_stmt_bind_result($stmt_check_stock, $current_stock);
        mysqli_stmt_fetch($stmt_check_stock);
        mysqli_stmt_close($stmt_check_stock);

        if ($current_stock < $jumlah[$i]) {
            // Jika stok tidak mencukupi, rollback dan beri peringatan
            mysqli_rollback($conn);
            header("Location: transaksi.php?status=stok_kurang");
            exit;
        }

        // Insert transaksi
        $query = "INSERT INTO transaksi (id_pengguna, id_obat, jumlah, total_harga, tanggal) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiiis', $id_pengguna, $id_barang[$i], $jumlah[$i], $total_harga[$i], $tanggal);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Kurangi stok obat
        $new_stock = $current_stock - $jumlah[$i];
        $query_update_stock = "UPDATE obat SET stock = ? WHERE id_obat = ?";
        $stmt_update_stock = mysqli_prepare($conn, $query_update_stock);
        mysqli_stmt_bind_param($stmt_update_stock, 'ii', $new_stock, $id_barang[$i]);
        mysqli_stmt_execute($stmt_update_stock);
        mysqli_stmt_close($stmt_update_stock);
    }

    // Commit transaksi jika semua query berhasil
    mysqli_commit($conn);
    header("Location: transaksi.php?status=sukses");
    exit; // Ensure script stops after header redirection
} catch (mysqli_sql_exception $exception) {
    // Rollback transaksi jika terjadi kesalahan
    mysqli_rollback($conn);
    header("Location: transaksi.php?status=gagal");
    exit; // Ensure script stops after header redirection
}
?>
