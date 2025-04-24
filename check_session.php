<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
} else {
    // ✅ Allow user to see sat6.html
    header("Location: sat6.html");
    exit();
}
?>
