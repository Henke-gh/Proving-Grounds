<?php
//ob_start();
require_once __DIR__ . "/startSession.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buyItem'])) {
    // Check if 'itemDetails' is set in the POST data
    if (isset($_POST['itemDetails']) && is_array($_POST['itemDetails'])) {
        foreach ($_POST['itemDetails'] as $itemDetail) {
            // Decode each item detail
            $item = json_decode($itemDetail, true);

            if ($_SESSION['hero']['gold'] >= $item['cost']) {
                // Deduct the cost from the player's resources
                $_SESSION['hero']['gold'] -= $item['cost'];
                $_SESSION['message'] = "You bought " . $item['name'] . ".";
                // Apply the item effects
                applyItemEffects($item);
            } else {
                // Handle insufficient funds
                $_SESSION['message'] = "I'm afraid your purse is too light..";
            }
        }
    }
}
header('Location: /../shop.php');
exit();
