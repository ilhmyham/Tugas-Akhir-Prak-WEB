<?php
$host = "localhost";
$user = "id22360964_apotek123";
$pass = "Apotek123_";
$db = "id22360964_apotek";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal : " . mysqli_connect_error());
}
