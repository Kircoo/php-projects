<?php ob_start(); ?>
<?php session_start(); ?>

<?php

$_SESSION['user_id'] = null;
$_SESSION['username'] = null;
$_SESSION['email'] = null;

header('location:../index.php');


?>