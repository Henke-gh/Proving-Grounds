<?php
//ob_start();
require_once __DIR__ . "/startSession.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buyItem'])) {
    // Check if 'itemDetails' is set in the POST data
    if (isset($_POST['itemDetails']) && is_array($_POST['itemDetails'])) {
        foreach ($_POST['itemDetails'] as $itemDetail) {
            // Decode each item detail
            $itemShopArray = json_decode($itemDetail, true);
            foreach ($itemShopArray as $itemType => $item) {
                if ($_SESSION['hero']['general']['gold'] >= $item['cost'] && !in_array($item['name'], $_SESSION['hero']['inventory'])) {
                    // Deduct the cost from the player's resources
                    $_SESSION['hero']['general']['gold'] -= $item['cost'];
                    $_SESSION['message'] = "You bought " . $item['name'] . ".";
                    // Apply the necessary item effects, default case assumes a healing-item.
                    switch ($itemType) {
                        case 'weapons':
                            applyWeaponItemEffects();
                            break;
                        case 'armour':
                            applyArmourItemEffects();
                            break;
                        case 'trinkets':
                            applyTrinketItemEffects();
                            break;

                        default:
                            applyHealingItemEffects();
                            break;
                    }
                } elseif (in_array($item['name'], $_SESSION['hero']['inventory'])) {
                    // Handle duplicates of unique items.
                    $_SESSION['message'] = "Unfortunately I can only sell you one of those.";
                } else {
                    // Handle insufficient funds
                    $_SESSION['message'] = "I'm afraid your purse is too light..";
                }
            }
        }
    }
}
header('Location: /../shop.php');
exit();
