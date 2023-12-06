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
    <?php if (isset($_SESSION['levelUpMsg'])) : ?>
        <div class="levelUpBox">
            <h3><?= "You have reached level " . $_SESSION['hero']['level'] . "!"; ?></h3>
            <?php foreach ($_SESSION['levelUpMsg'] as $line) : ?>
                <p><?= $line; ?></p>
            <?php endforeach;
            unset($_SESSION['levelUpMsg']); ?>
        </div>
    <?php endif; ?>
    <div class="heroMainWrap">
        <div class="myHeroWrap charSummary">
            <h3>Character Summary</h3>
            <img class="heroAvatar" src="<?= $avatars[$_SESSION['hero']['avatar']]['url']; ?>">
            <ul id="heroSummary">
                <li>
                    <h4><?= $_SESSION['hero']['name'] . " - Level: " . $_SESSION['hero']['level']; ?></h4>
                    <h4><?= $_SESSION['hero']['fameTitle']; ?></h4>
                </li>
                <li><?= "HP: " . $_SESSION['hero']['hitpoints'] . "/" . $_SESSION['hero']['hitpointsMax']; ?></li>
                <li><?= "Grit: " . $_SESSION['hero']['stamina'] . "/" . $_SESSION['hero']['staminaMax']; ?></li>
                <li><?= "Fame: " . $_SESSION['hero']['fame']; ?></li>
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
        </div>
        <div class="myHeroWrap charStats">
            <h3>Character Stats</h3>
            <ul id="heroSummary">
                <li><?= "Initiative: " . $_SESSION['hero']['initiative']; ?></li>
                <li><?= "Chance to Hit: " . $_SESSION['hero']['chanceToHit']; ?></li>
                <li><?= "Critical Strike Chance: " . $_SESSION['hero']['chanceToCrit'] . "%"; ?></li>
                <li><?= "Evasion: " . $_SESSION['hero']['evasion']; ?></li>
                <li><?= "Damage Reduction: " . $_SESSION['hero']['absorb']; ?></li>
            </ul>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . "/nav/footer.html";
