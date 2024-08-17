<?php

include 'connect.php';

session_start();
session_unset();
session_destroy();
echo "<script>alert('logout successfully')</script>";
header('location:../home.php');

?>