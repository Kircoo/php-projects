<?php ob_start(); ?>
<?php session_start(); ?>

<?php


$_SESSION['username'] = null;
$_SESSION['user_role'] = null;
$_SESSION['user_email'] = null;
$_SESSION['user_id'] = null;

header('location: index.php');


?>