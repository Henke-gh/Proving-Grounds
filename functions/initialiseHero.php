<?php
require __DIR__ . "/arrays.php";
require_once __DIR__ . "/functions.php";
session_start();

if (isset($_POST['createChar'])) {
    $weaponIndex = $_POST['weaponIndex'];
    $_SESSION['hero'] = $player;
    $_SESSION['hero']['general']['name'] = trim(htmlspecialchars($_POST['heroName'], ENT_QUOTES));
    $_SESSION['hero']['general']['gender'] = $_POST['heroGender'];
    $_SESSION['hero']['general']['avatar'] = (int) $_POST['heroAvatar'];
    $_SESSION['hero']['resource']['lastStaminaUpdate'] = time();
    $_SESSION['hero']['resource']['staminaRegenRate'] = 5;
    $_SESSION['hero']['resource']['lastHPupdate'] = time();
    $_SESSION['hero']['resource']['hpRegenRate'] = 2;
    $_SESSION['hero']['weapon'] = $startingWeapons[$weaponIndex];
    addWeaponBonuses();

    header('Location: /../app/myHero.php');
}
