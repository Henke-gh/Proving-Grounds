<?php
require_once __DIR__ . "/startSession.php";

if (isset($_SESSION['hero']) && $_SESSION['hero']['resource']['hitpoints'] < 0) {
    heroDeath();
} else {
    header('Location: /../app.myHero.php');
}
