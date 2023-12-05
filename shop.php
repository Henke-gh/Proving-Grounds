<?php
require_once __DIR__ . "/nav/header.php";
?>

<main>
    <h1 class="shopHeader">Gourflarbfth's Magnificent Emporium</h1>
    <div class="shopContainer">
        <div class="shop">
            <table class="shopItems">
                <?php
                $itemIndex = 0;
                foreach ($vendorItems as $itemType => $items) :
                    foreach ($items as $item) :
                ?>
                        <form method="post" action="shopCheckout.php">
                            <tr>
                                <td>
                                    <input type="hidden" name="itemDetails[]" value="<?= htmlentities(json_encode($item)); ?>">
                                    <p><?= $item['name'] . " - " . $item['cost'] . " gold"; ?></p>
                                </td>
                                <td><button type="submit" name="buyItem">Buy</button></td>
                            </tr>
                        </form>
                <?php
                        $itemIndex++;
                    endforeach;
                endforeach;
                ?>
            </table>
            <div class="playerShopInfo">
                <p><?= "Your gold: " . $_SESSION['hero']['gold']; ?></p>
            </div>
        </div>
        <div class="vendorBackContainer shopBox">
            <div class="vendorImg">
                <img src="/assets/images/goblin_vendor02.png">
                <?php if (isset($_SESSION['message'])) : ?>
                    <p><?= $_SESSION['message']; ?></p>
                <?php else : ?>
                    <p>My selection is quite unrivaled!..</p>
                <?php endif;
                unset($_SESSION['message']); ?>
            </div>
            <div class="vendorBack shopBox">
                <form method="post" action="index.php">
                    <button type="submit" name="back">Back</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . "/nav/footer.php";
