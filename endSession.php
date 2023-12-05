<?php
session_start();

if (isset($_POST['endSession'])) {
    unset($_SESSION['hero']);
    session_destroy();
    header('Location: index.php');
}
