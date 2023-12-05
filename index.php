<?php
require_once __DIR__ . "/nav/header.php";

if (isset($_SESSION['hero'])) {
    heroDeath();
    levelUp();
}
?>
<main>
    <?php if (isset($_SESSION['levelUpMsg'])) : ?>
        <div class="levelUpBox">
            <h4><?= $_SESSION['levelUpMsg']; ?></h4>
            <?php unset($_SESSION['levelUpMsg']); ?>
        </div>
    <?php endif; ?>
    <div class="characterCreateWrap">
        <?php if (!isset($_SESSION['hero'])) : ?>
            <form class="characterCreate" method="post" action="initialiseHero.php">
                <h2>Create your champion</h2>
                <label id="heroName">Name your hero:</label>
                <input id="heroName" type="text" required name="heroName">
                <label id="heroGender">Select gender:</label>
                <select id="heroGender" name="heroGender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label id="avatarChoice">Choose avatar:</label>
                <div class="avatarSelect">
                    <input type="hidden" value="" id="selectedAvatar" name="heroAvatar" required>
                    <?php
                    $avatarIndex = 0;
                    foreach ($avatars as $avatar) : ?>
                        <div class="avatar">
                            <img class="avatarImage" data-avatar-id="<?= $avatarIndex; ?>" src="<?= $avatar['url']; ?>">
                        </div>
                    <?php
                        $avatarIndex++;
                    endforeach; ?>
                </div>
                <label id="startingWeapon">Choose starting weapon:</label>
                <select name="weaponIndex">
                    <?php
                    $weaponIndex = 0;
                    foreach ($startingWeapons as $weapon) : ?>
                        <option value="<?= $weaponIndex ?>"><?= $weapon['name']; ?></option>
                    <?php
                        $weaponIndex++;
                    endforeach; ?>
                </select>
                <button type="submit" name="createChar">Create</button>
            </form>
        <?php else : ?>
            <h3>Character Summary</h3>
            <img class="heroAvatar" src="<?= $avatars[$_SESSION['hero']['avatar']]['url']; ?>">
            <ul id="heroSummary">
                <li>
                    <h4><?= $_SESSION['hero']['name'] . " - Level: " . $_SESSION['hero']['level']; ?></h4>
                </li>
                <li><?= "HP: " . $_SESSION['hero']['hitpoints'] . "/" . $_SESSION['hero']['hitpointsMax']; ?></li>
                <li><?= "Weapon: " . $_SESSION['hero']['weapon']['name']; ?></li>
                <li><?= "Gold: " . $_SESSION['hero']['gold']; ?></li>
                <li><?= "XP: " . $_SESSION['hero']['experience'] . "/" . $levelUp[$_SESSION['hero']['level']]['cost']; ?></li>
            </ul>
            <form method="post" action="combat.php">
                <button type="submit" name="doCombat">Choose opponent</button>
            </form>
            <form method="post" action="shop.php">
                <button type="submit" name="visitShop">Shop items</button>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php

echo '<pre>';
var_dump($_SESSION['hero']);
require_once __DIR__ . "/nav/footer.php";
