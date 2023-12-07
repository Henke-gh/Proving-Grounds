<?php
require __DIR__ . "/arrays.php";
require_once __DIR__ . "/functions.php";
session_start();

if (isset($_POST['createChar'])) {
    $weaponIndex = $_POST['weaponIndex'];
    $_SESSION['hero'] = $player;
    $_SESSION['hero']['name'] = trim(htmlspecialchars($_POST['heroName'], ENT_QUOTES));
    $_SESSION['hero']['gender'] = $_POST['heroGender'];
    $_SESSION['hero']['avatar'] = (int) $_POST['heroAvatar'];
    $_SESSION['hero']['lastStaminaUpdate'] = time();
    $_SESSION['hero']['staminaRegenRate'] = 3;
    $_SESSION['hero']['weapon'] = $startingWeapons[$weaponIndex];
    addWeaponBonuses();

    $_SESSION['heroInventory'] = $playerInventory;

    header('Location: /../myHero.php');
}
