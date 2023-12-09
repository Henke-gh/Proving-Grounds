<?php
require_once __DIR__ . "/../functions/startSession.php";
require_once __DIR__ . "/../nav/header.html";
?>
<main>
    <div class="aboutPageContainer">
        <?php if (isset($_SESSION['user_id'])) : ?>
            <h1><?= $_SESSION['username']; ?>'s User information</h1>
            <p>Nothing much here. Except a button that let's you delete you character if you wish to start over.
                Once you decide to delete your character there's NO TURNING BACK. Straight to Character Creation for you.
                Who doesn't like a fresh start?
            </p>
            <a href="/index.php"><button>Back</button></a>
            <h2>Here comes the Danger Zone</h2>
            <h2>Da-da-danger Zone!</h2>
            <form method="post" action="/../functions/charDelete.php">
                <button type="submit" name="heroDelete">Delete Hero</button>
            </form>
        <?php elseif ((!isset($_SESSION['user_id']))) : ?>
            <p>***cricket noises..***</p>
            <p>Register an account first, friend. That might do it!</p>
            <a href="/index.php"><button>Register Account</button></a>
        <?php endif; ?>
    </div>
</main>
<?php
require_once __DIR__ . "/../nav/footer.php";
