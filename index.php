<?php
require_once __DIR__ . "/functions/startSession.php";
if (isset($_SESSION['user_id'])) {
    header('Location: /app/myHero.php');
}
require_once __DIR__ . "/nav/header.html";
?>
<main>
    <div class="landingPageContainer">
        <h1>Welcome to the Proving Grounds</h1>
        <img src="/assets/images/crossing_swords.png">

        <?php if (isset($_SESSION['loginError'])) : ?>
            <p><?= $_SESSION['loginError']; ?></p>
        <?php endif;
        unset($_SESSION['loginError']); ?>

        <?php if (isset($_SESSION['userRegSuccess'])) : ?>
            <p><?= $_SESSION['userRegSuccess']; ?></p>
        <?php endif;
        unset($_SESSION['userRegSuccess']); ?>
        <p>Log in:</p>
        <form method="post" action="/functions/login.php">
            <label id="userName">Enter Username:</label>
            <input id="userName" name="userName" type="text" required>
            <label id="userPassword">Enter Password:</label>
            <input id="userPassword" name="userPassword" type="password" required>
            <button type="submit" name="userLogin">Log in</button>
        </form>

        <p>Not registered? Do you want to embark on an adventure? Register a new account:</p>
        <p>Take care to remember your password!</p>

        <?php if (isset($_SESSION['userRegError'])) : ?>
            <p><?= $_SESSION['userRegError']; ?></p>
        <?php endif;
        unset($_SESSION['userRegError']); ?>

        <form method="post" action="/functions/registerNewUser.php">
            <label id="newUserName">Enter Username:</label>
            <input id="newUserName" name="newUserName" type="text" required>
            <label id="newUserPassword">Enter Password:</label>
            <input id="newUserPassword" name="newUserPassword" type="password" required>
            <label id="newUserPasswordRepeat">Repeat Password:</label>
            <input id="newUserPasswordRepeat" name="newUserPasswordRepeat" type="password" required>
            <button type="submit" name="registerNew">Register</button>
        </form>
    </div>
</main>
<?php
require_once __DIR__ . "/nav/footer.html";
