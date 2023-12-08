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
        <div class="loginNewsContainer">
            <div class="landingLogin login">
                <?php if (isset($_SESSION['loginError'])) : ?>
                    <p><?= $_SESSION['loginError']; ?></p>
                <?php endif;
                unset($_SESSION['loginError']); ?>

                <?php if (isset($_SESSION['userRegSuccess'])) : ?>
                    <p><?= $_SESSION['userRegSuccess']; ?></p>
                <?php endif;
                unset($_SESSION['userRegSuccess']); ?>
                <h2>Log in:</h2>
                <form method="post" action="/functions/login.php">
                    <label id="userName">Enter Username:</label>
                    <input id="userName" name="userName" type="text" required>
                    <label id="userPassword">Enter Password:</label>
                    <input id="userPassword" name="userPassword" type="password" required>
                    <button type="submit" name="userLogin">Log in</button>
                </form>
            </div>
            <div class="landingLogin">
                <h2>News 8/12-23</h2>
                <article>
                    <p>Login-system, such wow! Also, your progress is now saved.
                        The End Session button is now the Log Out button, which also saves your progress.</p>
                    <p>Don't worry, the game saves regularly even while playing.
                        Saving might mess up if you switch platforms without logging out though so beware.</p>
                    <p>Next up - Monsters and Items. More.</p>
                </article>
            </div>
        </div>

        <div class="landingLogin">
            <h2>Register new account:</h2>
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
    </div>
</main>
<?php
require_once __DIR__ . "/nav/footer.html";
