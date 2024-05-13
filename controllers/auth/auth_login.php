<?php
session_start();

include "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM tb_user WHERE username='$username' AND password='$password' AND status=1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['status'] = 'login';
                header("location:../../index.php");
            } else {
                echo "<script>alert('Username atau Password salah'); window.location.href='../../pages/auth/login.php';</script>";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Please provide both username and password.";
    }
}
?>
