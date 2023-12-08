<?php
require_once __DIR__ . "/startSession.php";
if (isset($_POST['barWork']) && $_SESSION['hero']['resource']['stamina'] > 35) {
    $_SESSION['hero']['general']['gold'] += 15;
    $_SESSION['hero']['resource']['stamina'] -= 35;
    $_SESSION['barComplete'] = "What, you want applause? Take your gold and get out..";
} else {
    $_SESSION['barComplete'] = "Didn't think you were up for it. Weren't wrong.";
}
savePlayerProgress();
header('Location: /../app/tavern.php');
exit();
