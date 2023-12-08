<?php

declare(strict_types=1);
require_once __DIR__ . "/startSession.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerNew'])) {
    $newUsername = (string) trim(strtolower(htmlspecialchars($_POST['newUserName'], ENT_QUOTES)));
    $newUserPW = (string) trim(htmlspecialchars($_POST['newUserPassword'], ENT_QUOTES));
    $newUserPWrepeat = (string) trim(htmlspecialchars($_POST['newUserPasswordRepeat'], ENT_QUOTES));
    if (!isUsernameAvailable($newUsername, $db)) {
        $_SESSION['userRegError'] = "Username unavailable. Please pick another one.";
        header('Location: /../index.php');
        exit();
    } elseif ($newUserPW !== $newUserPWrepeat) {
        $_SESSION['userRegError'] = "Password does not match. Please try again.";
        header('Location: /../index.php');
        exit();
    } else {
        $hashedPW = password_hash($newUserPW, PASSWORD_DEFAULT);
    }

    $prepare = $db->prepare('INSERT INTO users (username, password_Hash)
            VALUES (:userName, :userPW)');

    $prepare->bindParam(':userName', $newUsername);
    $prepare->bindParam(':userPW', $hashedPW);
    $prepare->execute();

    $_SESSION['userRegSuccess'] = "New account created! Login to continue.";
} elseif ($newUserPW !== $newUserPWrepeat) {
    $message = "Incorrect password. Try again.";
}

header('Location: /../index.php');
exit();
