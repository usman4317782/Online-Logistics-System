<?php
session_start();

if (!isset($_SESSION)) {
    header("Location: ../sign-in.php");
}
if (isset($_SESSION)) {
    session_destroy();
    header("Location: ../sign-in.php");
}
