<?php
require __DIR__ . "/startSession.php";

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

    $playerData = json_encode($_SESSION['hero']);
    $version = 1;

    $prepare = $db->prepare('INSERT INTO playerHero (user_id, playerHero_data, version)
            VALUES (:userID, :heroData, :version)');

    $prepare->bindParam(':userID', $_SESSION['user_id']);
    $prepare->bindParam(':heroData', $playerData);
    $prepare->bindParam(':version', $version);
    $prepare->execute();

    header('Location: /../app/myHero.php');
}
