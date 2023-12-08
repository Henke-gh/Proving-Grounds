<?php
require_once __DIR__ . "/functions/startSession.php";
if (isset($_SESSION['hero'])) {
    header('Location: /app/myHero.php');
}
require_once __DIR__ . "/nav/header.html";
?>
<main>
    <div class="landingPageContainer">
        <h1>Welcome to the Proving Grounds</h1>
        <img src="/assets/images/crossing_swords.png">
        <p>Log in:</p>
        <form method="post" action="/functions/login.php">
            <label id="userName">Enter Username:</label>
            <input id="userName" type="text" required>
            <label id="userPassword">Enter Password:</label>
            <input id="userPassword" type="password" required>
            <button type="submit" name="userLogin">Log in</button>
        </form>

        <p>Not registered? Do you want to embark on an adventure? Register a new account:</p>
        <form action="post" accept="/function/registerNewUser.php">
            <label id="newUserName">Enter Username:</label>
            <input id="newUserName" type="text" required>
            <label id="newUserPassword">Enter Password:</label>
            <input id="newUserPassword" type="password" required>
            <label id="newUserPasswordRepeat">Repeat Password:</label>
            <input id="newUserPasswordRepeat" type="password" required>
            <button type="submit" name="registerNew">Register</button>
        </form>
    </div>
</main>
<?php
require_once __DIR__ . "/nav/footer.html";
