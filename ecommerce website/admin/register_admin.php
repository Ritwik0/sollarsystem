<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:register_admin.php');
    exit();
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);

    if ($select_admin->rowCount() > 0) {
      echo "<script>alert('Username Already Exists!')</script>";
    } else {
        if ($pass !== $cpass) {
            echo "<script>alert('Confirm Password Does Not Match!')</script>";
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admins` (name, password) VALUES (?, ?)");
            $insert_admin->execute([$name, $pass]);
            echo "<script>alert('Registration successfully')</script>";
            echo "<script>window.open('admin_login.php','_self')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

    <form action="" method="post">
        <h3>Register Now</h3>
        <!-- <?php
      //   if (isset($message)) {
      //       foreach ($message as $msg) {
      //           echo '<p class="message">'.$msg.'</p>';
      //       }
      //   }
      //   ?> -->
        <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Register Now" class="btn" name="submit">
    </form>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>