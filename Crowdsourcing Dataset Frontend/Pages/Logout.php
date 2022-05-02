<?php include('../../config/server.php') ?>

<?php
// session_start();
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

unset($_SESSION['username']);
// redirect("location: Login.php");
header('location: User.php');
?>