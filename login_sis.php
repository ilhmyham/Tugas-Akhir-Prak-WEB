<?php
include "config.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $val = mysqli_query($conn, $sql);

    if (mysqli_num_rows($val) > 0) {
        $row = mysqli_fetch_assoc($val);
        $status = $row['status'];
        $_SESSION['username'] = $username;
        $_SESSION['id_pengguna'] = $row['id'];

        if ($status === 'user') {
            header("Location: User/dashboardUser.php");
            exit();
        } elseif ($status === 'admin') {
            header("Location: Admin/dashboard.php");
            exit();
        }
    } else {
        echo "<script>
        alert('Username or password incorrect');
        document.location='index.php';
        </script>";
    }
} else {
    die("Access denied!");
}
?>
