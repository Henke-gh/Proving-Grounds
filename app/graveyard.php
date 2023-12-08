<?php
require_once __DIR__ . "/../functions/startSession.php";
require_once __DIR__ . "/../nav/header.html";
if ($_SESSION['hero']['resource']['hitpoints'] < 0) {
    unset($_SESSION['hero']);
}
?>

<main>
    <h1>You have perished..</h1>
    <img class="graveyardImg" src="/../assets/images/player_death_small.png">
    <form action="/../functions/endSession.php" method="post">
        <button type="submit" name="endSession">New Game</button>
    </form>
</main>

<?php
require_once __DIR__ . "/../nav/footer.html";
