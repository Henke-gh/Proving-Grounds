<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userLogin'])) {
    header(('Location: /../app/createNewHero.php'));
} else {
    header('Location: /../index.php');
}
exit();