<?php
require_once __DIR__ . "/nav/header.php";
?>

<main>
    <div class="playerShopInfo">
        <ul>
            <li>
                <h4><?= $_SESSION['hero']['name']; ?></h4>
                <h5><?= "Level: " . $_SESSION['hero']['level']; ?></h5>
            </li>
            <li><?= "HP: " . $_SESSION['hero']['hitpoints'] . "/" . $_SESSION['hero']['hitpointsMax']; ?></li>
            <li><?= "Weapon: " . $_SESSION['hero']['weapon']['name']; ?></li>
            <li><?= "Gold: " . $_SESSION['hero']['gold']; ?></li>
        </ul>
        <img class="heroAvatar" src="<?= $avatars[$_SESSION['hero']['avatar']]['url']; ?>">
    </div>
    <div class="shopContainer">
        <img class="heroAvatar" src="/assets/images/goblin_vendor.png">
        <div class="shop">
            <h3>Gourflarbfth's Exotic Goods</h3>
            <?php if (isset($_SESSION['message'])) : ?>
                <p><?= $_SESSION['message']; ?></p>
            <?php endif;
            unset($_SESSION['message']); ?>
            <table class="shopItems">
                <?php
                $itemIndex = 0;
                foreach ($vendorItems as $itemType => $items) : ?>
                    <?php foreach ($items as $item) : ?>
                        <form method="post" action="shopCheckout.php">
                            <tr>
                                <td><input type="hidden" name="getType" value="<?= $itemType; ?>">
                                    <input type="hidden" name="getIndex" value="<?= $itemIndex; ?>">
                                    <p><?= $item['name'] . " - " . $item['cost'] . " gold"; ?></p>
                                </td>
                                <!-- <td><button type="menu">Info</button></td> -->
                                <td><button type="submit" name="buyItem">Buy</button></td>
                            </tr>
                        </form>
                <?php
                        $itemIndex++;
                    endforeach;
                endforeach; ?>
            </table>
            <form method="post" action="index.php">
                <button type="submit" name="back">Back</button>
            </form>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . "/nav/footer.php";
