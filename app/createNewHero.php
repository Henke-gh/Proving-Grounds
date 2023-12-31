<?php
require_once __DIR__ . "/../functions/startSession.php";
if (isset($_SESSION['hero'])) {
    header('Location: myHero.php');
}
require_once __DIR__ . "/../nav/header.html";
?>
<main>
    <div class="characterCreateWrap">
        <?php if (!isset($_SESSION['hero'])) : ?>
            <form class="characterCreate" method="post" action="/../functions/initialiseHero.php">
                <h2>Create your champion</h2>
                <label id="heroName">Name your hero:</label>
                <input class="heroNameInput" id="heroName" type="text" required name="heroName">
                <label id="heroGender">Select gender:</label>
                <select id="heroGender" name="heroGender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label id="avatarChoice">Choose avatar:</label>
                <div class="avatarSelect">
                    <input type="hidden" value="" id="selectedAvatar" name="heroAvatar" required>
                    <?php
                    $avatarIndex = 0;
                    foreach ($avatars as $avatar) : ?>
                        <div class="avatar">
                            <img class="avatarImage" data-avatar-id="<?= $avatarIndex; ?>" src="<?= $avatar['url']; ?>">
                        </div>
                    <?php
                        $avatarIndex++;
                    endforeach; ?>
                </div>
                <label id="startingWeapon">Choose starting weapon:</label>
                <select name="weaponIndex">
                    <?php
                    $weaponIndex = 0;
                    foreach ($startingWeapons as $weapon) : ?>
                        <option value="<?= $weaponIndex ?>"><?= $weapon['name']; ?></option>
                    <?php
                        $weaponIndex++;
                    endforeach; ?>
                </select>
                <button type="submit" name="createChar">Create</button>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php
require_once __DIR__ . "/../nav/footer.php";
