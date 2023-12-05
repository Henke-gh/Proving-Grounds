<?php
require __DIR__ . "/arrays.php";
session_start();

if (isset($_POST['createChar'])) {
    $weaponIndex = $_POST['weaponIndex'];
    $_SESSION['hero'] = $player;
    $_SESSION['hero']['name'] = trim(htmlspecialchars($_POST['heroName'], ENT_QUOTES));
    $_SESSION['hero']['gender'] = $_POST['heroGender'];
    $_SESSION['hero']['avatar'] = (int) $_POST['heroAvatar'];
    $_SESSION['hero']['weapon'] = $startingWeapons[$weaponIndex];
    $_SESSION['hero']['initiative'] = $_SESSION['hero']['initiative'] + $_SESSION['hero']['weapon']['initiative'];

    header('Location: /../myHero.php');
}
