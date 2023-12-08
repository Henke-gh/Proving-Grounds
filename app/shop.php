<?php
require_once __DIR__ . "/../functions/startSession.php";
require_once __DIR__ . "/../nav/header.html";
if (isset($_SESSION['hero']) && $_SESSION['hero']['resource']['hitpoints'] > 0) {
    heroDeath();
    checkRegenerationTime();
    levelUp();
} else {
    unset($_SESSION['hero']);
    header('Location: /app/createNewHero.php');
}
?>

<main>
    <h1 class="shopHeader">Gourflarbfth's Magnificent Emporium</h1>
    <div class="shopSelect">
        <?php foreach ($vendorItems as $category => $items) : ?>
            <button onclick="showCategory('<?= $category; ?>')"><?= ucfirst($category); ?></button>
        <?php endforeach; ?>
    </div>
    <div class="playerShopInfo">
        <h3><?= $_SESSION['hero']['general']['name']; ?></h3>
        <p>Current gold: <?= $_SESSION['hero']['general']['gold']; ?></p>
        <p>Current HP: <?= $_SESSION['hero']['resource']['hitpoints'] . "/" . $_SESSION['hero']['resource']['hitpointsMax']; ?></p>
    </div>
    <div class="shopContainer">
        <div class="shopItems">
            <?php foreach ($vendorItems as $category => $items) : ?>
                <div class="category" id="<?= $category; ?>">
                    <h2><?= ucfirst($category); ?></h2>
                    <div class="shopGridBox">
                        <?php foreach ($items as $item) : ?>
                            <div class="shopGridItem">
                                <form method="post" action="/../functions/shopCheckout.php">
                                    <ul class="items">
                                        <li class="item">
                                            <input type="hidden" name="itemDetails[]" value="<?= htmlentities(json_encode($itemArray = [$category => $item])); ?>">
                                            <h3><?= $item['name']; ?></h3>
                                            <?php foreach ($item as $key => $value) : ?>
                                                <?php
                                                $displayKey = getDisplayKey($key);
                                                if ($key !== 'name') : ?>
                                                    <p><?= ucfirst($displayKey) . ': ' . $value; ?></p>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <button type="submit" name="buyItem">Buy</button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="vendorBackContainer shopBox">
            <div class="vendorImg">
                <img src="/../assets/images/goblin_vendor02.png">
                <?php if (isset($_SESSION['message'])) : ?>
                    <p><?= $_SESSION['message']; ?></p>
                <?php else : ?>
                    <p>My selection is quite unrivaled!..</p>
                <?php endif;
                unset($_SESSION['message']); ?>
                <a href="/app/myHero.php"><button type="submit" name="back">Back</button></a>
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . "/../nav/footer.html";
