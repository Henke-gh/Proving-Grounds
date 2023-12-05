<?php
//ob_start();
//require_once __DIR__ . "/arrays.php";
require_once __DIR__ . "/nav/header.php";
if (isset($_POST['buyItem'])) {
    $itemIndex = $_POST['getIndex'];
    $itemType = $_POST['getType'];
    if ($_SESSION['hero']['gold'] < $vendorItems[$itemType][$itemIndex]['cost']) {
        $_SESSION['message'] = "Sorry, you are short on gold..";
        header('Location: shop.php');
        //ob_end_flush();
        //header('Location: https://henkes-portfolio.se/ProvingGrounds/shop.php');
    } elseif ($itemType === 'healing') {
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpoints'] + $vendorItems[$itemType][$itemIndex]['hitpoints'];
        $_SESSION['hero']['gold'] = $_SESSION['hero']['gold'] - $vendorItems[$itemType][$itemIndex]['cost'];
        if ($_SESSION['hero']['hitpoints'] > $_SESSION['hero']['hitpointsMax']) {
            $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpointsMax'];
        }
        $_SESSION['message'] = "You've bought " . $vendorItems[$itemType][$itemIndex]['name'];
        header('Location: shop.php');
        //ob_end_flush();
        //header('Location: https://henkes-portfolio.se/ProvingGrounds/shop.php');
    } else {
        $_SESSION['message'] = "Sorry, not in stock.";
        header('Location: shop.php');
    }
}
