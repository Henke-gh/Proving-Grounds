<?php
require_once __DIR__ . '/startSession.php';

if (isset($_POST['endSession'])) {
    if ($_SESSION['hero']['resource']['hitpoints'] > 0) {
        savePlayerProgress();
    }
    unset($_SESSION['hero']);
    unset($_SESSION['id']);
    session_destroy();
    header('Location: /../index.php');
    exit();
}
