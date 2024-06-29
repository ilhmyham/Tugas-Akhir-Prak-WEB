<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

echo "Selamat Datang, " . $_SESSION['username'] . "!";
echo "<a href='../logout.php'>Logout</a>";
