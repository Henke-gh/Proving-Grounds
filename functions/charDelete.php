<?php
require_once __DIR__ . "/startSession.php";

if (isset($_POST['heroDelete'])) {
    deletePlayerData();
    unset($_SESSION['hero']);
    header('Location: /../app/createNewHero.php');
}
