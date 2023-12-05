<?php
require_once __DIR__ . "/nav/header.php";

if (isset($_POST['monster'], $_POST['retreatValue'])) {
    $monsterIndex = $_POST['monster'];
    $playerRetreat = $_POST['retreatValue'];
    doBattle($playerRetreat);
}
?>

<main>
    <img src="/assets/images/crossing_swords.png">
    <h3>Monster Duel</h3>
    <?php if (!isset($_POST['monster'])) : ?>
        <div class="monsterSelect">
            <form method="post">
                <label id="monsterSelect">Select foe:</label>
                <select name="monster" id="monsterSelect">
                    <?php
                    $monsterIndex = 0;
                    foreach ($monsterTypes as $monster) : ?>
                        <option value="<?= $monsterIndex; ?>"> <?= $monster['name']; ?></option>
                    <?php
                        $monsterIndex++;
                    endforeach; ?>
                </select>
                <label id="hpSelect">Retreat at HP:</label>
                <select name="retreatValue" id="hpSelect">
                    <?php
                    $retreat = 0;
                    for ($i = 0; $i < 11; $i++) : ?>
                        <option value="<?= $retreat; ?>"><?= $retreat . "%"; ?></option>
                    <?php
                        $retreat = $retreat + 10;
                    endfor; ?>
                </select>
                <button type="submit">Do battle!</button>
            </form>
            <form action="index.php">
                <button type="submit">Back</button>
            </form>
        </div>
    <?php else : ?>
        <h3><?= $_SESSION['hero']['name'] . " vs " . $monsterTypes[$monsterIndex]['name']; ?></h3>
        <div class="combatLog">
            <?php foreach ($combatLog as $line) : ?>
                <p class="combatText"><?= $line; ?></p>
            <?php endforeach; ?>
            <form method="post" action="index.php">
                <button type="submit" name="afterCombat">Continue</button>
            </form>
        </div>
    <?php endif; ?>

</main>

<?php
require_once __DIR__ . "/nav/footer.php";
?>