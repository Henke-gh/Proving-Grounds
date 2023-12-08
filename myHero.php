<?php
require_once __DIR__ . "/functions/startSession.php";
if (isset($_SESSION['hero'])) {
    checkRegenerationTime();
    heroDeath();
    levelUp();
}
require_once __DIR__ . "/nav/header.html";
?>

<main>
    <nav class="gameNav">
        <a href="/combat.php"><button type="submit" name="doCombat">Enter the Arena</button></a>
        <a href="/shop.php"> <button type="submit" name="visitShop">Visit Emporium</button></a>
        <a href="/tavern.php"> <button type="submit" name="visitShop">Tavern</button></a>
    </nav>
    <?php if (isset($_SESSION['levelUpMsg'])) : ?>
        <div class="levelUpBox">
            <h3><?= "You have reached level " . $_SESSION['hero']['general']['level'] . "!"; ?></h3>
            <?php foreach ($_SESSION['levelUpMsg'] as $line) : ?>
                <p><?= $line; ?></p>
            <?php endforeach;
            unset($_SESSION['levelUpMsg']); ?>
        </div>
    <?php endif; ?>
    <div class="heroMainWrap">
        <div class="myHeroWrap charSummary">
            <h3>Character Summary</h3>
            <img class="heroAvatar" src="<?= $avatars[$_SESSION['hero']['general']['avatar']]['url']; ?>">
            <ul id="heroSummary">
                <li>
                    <h4><?= $_SESSION['hero']['general']['name'] . " - Level: " . $_SESSION['hero']['general']['level']; ?></h4>
                    <h4><?= $_SESSION['hero']['general']['fameTitle']; ?></h4>
                </li>
                <li><span class="bold">HP: </span><?= $_SESSION['hero']['resource']['hitpoints'] . "/" . $_SESSION['hero']['resource']['hitpointsMax']; ?></li>
                <li><span class="bold">Grit: </span><?= $_SESSION['hero']['resource']['stamina'] . "/" . $_SESSION['hero']['resource']['staminaMax']; ?></li>
                <li><span class="bold">Fame: </span><?= $_SESSION['hero']['general']['fame']; ?></li>
                <li><span class="bold">Gold: </span><?= $_SESSION['hero']['general']['gold']; ?></li>
                <li><span class="bold">XP: </span><?= $_SESSION['hero']['general']['experience'] . "/" . $levelUp[$_SESSION['hero']['general']['level']]['cost']; ?></li>
            </ul>
        </div>
        <div class="myHeroWrap charStats">
            <h3>Inventory</h3>
            <ul id="heroSummary">
                <h4>Equipment</h4>
                <li><span class="bold">Weapon: </span><?= $_SESSION['hero']['weapon']['name']; ?></li>
                <li><span class="bold">Armour: </span><?= $_SESSION['hero']['armour']['name']; ?></li>
                <?php
                if (!empty($_SESSION['heroInventory'])) : ?>
                    <h4>Magical Objects</h4>
                    <?php foreach ($_SESSION['hero']['inventory'] as $item) : ?>
                        <li><span class="bold">Trinket: </span><?= $item; ?></li>
                <?php endforeach;
                endif; ?>
            </ul>
            <h3>Character Stats</h3>
            <ul id="heroSummary">
                <li><span class="bold">Damage: </span><?= $_SESSION['hero']['weapon']['damage']; ?></li>
                <li><span class="bold">Initiative: </span><?= $_SESSION['hero']['combat']['initiative']; ?></li>
                <li><span class="bold">Chance to Hit: </span><?= $_SESSION['hero']['combat']['chanceToHit']; ?></li>
                <li><span class="bold">Critical Strike Chance: </span><?= $_SESSION['hero']['combat']['chanceToCrit'] . "%"; ?></li>
                <li><span class="bold">Evasion: </span><?= $_SESSION['hero']['combat']['evasion']; ?></li>
                <li><span class="bold">Damage Reduction: </span><?= $_SESSION['hero']['combat']['absorb']; ?></li>
            </ul>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . "/nav/footer.html";
