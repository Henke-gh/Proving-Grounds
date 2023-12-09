<?php
require_once __DIR__ . "/../functions/startSession.php";
require_once __DIR__ . "/../nav/header.html";

checkRegenerationTime();
if (isset($_POST['monster'], $_POST['retreatValue'])) {
    $monsterIndex = $_POST['monster'];
    $playerRetreat = $_POST['retreatValue'];
    if ($_SESSION['hero']['resource']['stamina'] <= 0) {
        $_SESSION['staminaDepleted'] = "Your hero lacks the grit to press on. Maybe you should rest?";
    } else {
        doBattle($playerRetreat);
        savePlayerProgress();
    }
}
?>

<main>
    <img src="/../assets/images/crossing_swords.png">
    <h3>Monster Duel</h3>
    <?php if (isset($_SESSION['staminaDepleted'])) : ?>
        <div class="monsterSelect">
            <p><?= $_SESSION['staminaDepleted']; ?></p>
            <form action="/../app/myHero.php">
                <button type="submit">Back</button>
            </form>
        </div>
    <?php endif;
    unset($_SESSION['staminaDepleted']); ?>
    <?php if (!isset($_POST['monster'])) : ?>
        <div class="playerShopInfo combatInfo">
            <h3><?= $_SESSION['hero']['general']['name']; ?></h3>
            <p>HP: <?= $_SESSION['hero']['resource']['hitpoints'] . "/" . $_SESSION['hero']['resource']['hitpointsMax']; ?></p>
            <p>Grit: <?= $_SESSION['hero']['resource']['stamina'] . "/" . $_SESSION['hero']['resource']['staminaMax']; ?></p>
        </div>
        <div class="monsterSelect">
            <form method="post">
                <label id="monsterSelect">Select foe:</label>
                <select name="monster" id="monsterSelect">
                    <?php
                    $monsterIndex = 0;
                    foreach ($monsterTypes as $monster) : ?>
                        <option value="<?= $monsterIndex; ?>"><?= "[lv. " . $monster['level'] . "] " . $monster['name']; ?></option>
                    <?php
                        $monsterIndex++;
                    endforeach; ?>
                </select>
                <label id="hpSelect">Retreat at HP:</label>
                <select name="retreatValue" id="hpSelect">
                    <?php
                    $retreat = 100;
                    for ($i = 0; $i < 11; $i++) : ?>
                        <option value="<?= $retreat; ?>"><?= $retreat . "%"; ?></option>
                    <?php
                        $retreat = $retreat - 10;
                    endfor; ?>
                </select>
                <button type="submit">Do battle!</button>
            </form>
            <form class="combatBack" action="/../app/myHero.php">
                <button type="submit">Back</button>
            </form>
        </div>
    <?php elseif (!empty($combatLog)) : ?>
        <h3><?= $_SESSION['hero']['general']['name'] . " vs " . $monsterTypes[$monsterIndex]['name']; ?></h3>
        <div class="combatLog">
            <?php foreach ($combatLog as $line) : ?>
                <p class="combatText"><?= $line; ?></p>
            <?php endforeach; ?>
            <form method="post" action="/functions/resolveCombat.php">
                <button type="submit" name="afterCombat">Continue</button>
            </form>
        </div>
    <?php endif; ?>

</main>

<?php
require_once __DIR__ . "/../nav/footer.php";
?>