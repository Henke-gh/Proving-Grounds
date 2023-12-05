<?php
require_once __DIR__ . "/nav/header.php";
?>

<main>
    <h4>You have perished..</h4>
    <img src="/assets/images/player_death_small.png">
    <form action="endSession.php" method="post">
        <button type="submit" name="endSession">New Game</button>
    </form>
</main>

<?php
require_once __DIR__ . "/nav/footer.php";
