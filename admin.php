<?php
session_start();

/*
 * hier kom je alleen als je een admin
 * admin kan hier de punten invoeren
 * ook kan de admin andere mensen rechten geven
 */


if (!isset($_SESSION['id'])) {
    die("I'm sorry, this page is locked, <a href='login.php'>Login</a> first.");
}

?>

