<?php

function combatInitiative()
{
    global $monsterTypes, $monsterIndex, $initiative;
    if ($_SESSION['hero']['combat']['initiative'] >= $monsterTypes[$monsterIndex]['initiative']) {
        if ($_SESSION['hero']['combat']['initiative'] < toHitValue()) {
            $initiative = $monsterTypes[$monsterIndex]['name'];
            return false;
        } else {
            $initiative = $_SESSION['hero']['general']['name'];
            return true;
        }
    } elseif ($monsterTypes[$monsterIndex]['initiative'] < toHitValue()) {
        $initiative = $_SESSION['hero']['general']['name'];
        return true;
    } else {
        $initiative = $monsterTypes[$monsterIndex]['name'];
        return false;
    }
    return $initiative;
}

//this function relates to the combat initiative-function.
function toHitValue()
{
    $toHit = rand(1, 20);
    return $toHit;
}

//these relate to player and monster Chance to hit.
function toHitValuePlayer()
{
    global $monsterTypes, $monsterIndex;
    $toHit = rand(1, 10) + $monsterTypes[$monsterIndex]['evasion'];
    return $toHit;
}

function toHitValueMonster()
{
    $toHit = rand(1, 10) + $_SESSION['hero']['combat']['evasion'];
    return $toHit;
}

//determines the success and outcome of player attack
function playerAttack()
{
    global $monsterTypes, $monsterIndex, $combatLog, $criticalDamage;

    $criticalDamage = $_SESSION['hero']['weapon']['damage'] * 1.5;
    $damage = $_SESSION['hero']['weapon']['damage'];
    if ($damage < 0) {
        $damage = 0;
    }
    $critChance = $_SESSION['hero']['combat']['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $_SESSION['hero']['general']['name'] . " charges with " . getPlayerGender() . " " . $_SESSION['hero']['weapon']['name'] . "!");
    if ($critChance >= $toCrit) {
        array_push($combatLog, $_SESSION['hero']['general']['name'] . " delivers a crushing blow to " . $monsterTypes[$monsterIndex]['name'] . " for<strong> " . floor($criticalDamage) . " damage!</strong>");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - floor($criticalDamage);
    } elseif ($_SESSION['hero']['combat']['chanceToHit'] < toHitValuePlayer()) {
        array_push($combatLog, $_SESSION['hero']['general']['name'] . " missed..");
    } else {
        array_push($combatLog, $_SESSION['hero']['general']['name'] . " hits " . $monsterTypes[$monsterIndex]['name'] . " for " . $damage . " damage!");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - $damage;
    }
};

function monsterAttack()
{
    global $monsterTypes, $monsterIndex, $combatLog, $criticalDamage;

    $criticalDamage = $monsterTypes[$monsterIndex]['weapon']['damage'] * 1.5;
    $damage = $monsterTypes[$monsterIndex]['weapon']['damage'] - $_SESSION['hero']['combat']['absorb'];
    //negative damage values causes that which is hit to gain HP and it's all sorts of bad...
    if ($damage < 0) {
        $damage = 0;
    }
    $critChance = $monsterTypes[$monsterIndex]['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " swings its " . $monsterTypes[$monsterIndex]['weapon']['name'] . "!");
    if ($critChance >= $toCrit) {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " strikes a murderous blow to " . $_SESSION['hero']['general']['name'] . " for <strong>" . floor($criticalDamage) . " damage!</strong>");
        $_SESSION['hero']['resource']['hitpoints'] = $_SESSION['hero']['resource']['hitpoints'] - floor($criticalDamage);
    } elseif ($monsterTypes[$monsterIndex]['chanceToHit'] < toHitValueMonster()) {
        array_push($combatLog, "Phew, " . $monsterTypes[$monsterIndex]['name'] . " missed..");
    } else {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " hits " . $_SESSION['hero']['general']['name'] . " for " . $damage . " damage!");
        $_SESSION['hero']['resource']['hitpoints'] = $_SESSION['hero']['resource']['hitpoints'] - $damage;
    }
}

//Checks player HP to determine whether player has died or not.
//If dead, wipes playerHero_data, it's new character time!
function heroDeath()
{
    global $db;

    if (isset($_SESSION['user_id']) && $_SESSION['hero']['resource']['hitpoints'] <= 0) {
        try {
            // Prepare and execute the DELETE statement
            $stmt = $db->prepare('DELETE FROM playerHero WHERE user_id = :userID');
            $stmt->bindParam(':userID', $_SESSION['user_id']);
            $stmt->execute();

            // Output success message or perform other actions if needed
            //echo "Player data deleted successfully.";
        } catch (PDOException $e) {
            // Handle errors
            echo "Error: " . $e->getMessage();
        }
        header('Location: /../app/graveyard.php');
    }
}

//If player level is dividable by 2: Add +1 chance to hit, else add +1 Evasion.
function checkToAddEvasionOrHitChance($level)
{
    if ($level % 2 == 0) {
        $_SESSION['hero']['combat']['chanceToHit'] = $_SESSION['hero']['combat']['chanceToHit'] + 1;
        array_push($_SESSION['levelUpMsg'], "You gain +1 Chance to Hit.");
    } else {
        $_SESSION['hero']['combat']['evasion'] = $_SESSION['hero']['combat']['evasion'] + 1;
        array_push($_SESSION['levelUpMsg'], "You gain +1 Evasion.");
    }
}

//Controls hero Level-up. Checks player XP and if player has reached next bracket
//increases hero stat values.
function levelUp()
{
    global $levelUp, $fameTitle;

    $newFameLevel = $_SESSION['hero']['general']['fameLevel'] + 1;
    if ($_SESSION['hero']['general']['level'] < 20) {
        if ($_SESSION['hero']['general']['experience'] >= $levelUp[$_SESSION['hero']['general']['level']]['cost']) {
            $_SESSION['levelUpMsg'] = [];
            $_SESSION['hero']['general']['level'] = $_SESSION['hero']['general']['level'] + 1;
            $_SESSION['hero']['general']['fame'] = $_SESSION['hero']['general']['fame'] + 5;
            if ($_SESSION['hero']['general']['fame'] >= $fameTitle[$newFameLevel]['fame']) {
                $_SESSION['hero']['general']['fameLevel'] = $_SESSION['hero']['general']['fameLevel'] + 1;
                $_SESSION['hero']['general']['fameTitle'] = $fameTitle[$_SESSION['hero']['general']['fameLevel']]['title'];
            }
            $_SESSION['hero']['resource']['hitpointsMax'] = $_SESSION['hero']['resource']['hitpointsMax'] + 5;
            $_SESSION['hero']['resource']['hitpoints'] = $_SESSION['hero']['resource']['hitpointsMax'];
            $_SESSION['hero']['resource']['stamina'] = $_SESSION['hero']['resource']['staminaMax'];
            $_SESSION['hero']['general']['gold'] += 75;
            array_push($_SESSION['levelUpMsg'], "You gain +5 Max HP.");
            array_push($_SESSION['levelUpMsg'], "You gain +5 Fame.");
            checkToAddEvasionOrHitChance($_SESSION['hero']['general']['level']);
            array_push($_SESSION['levelUpMsg'], "You earn 75 gold!");
        }
    } else {
        $_SESSION['hero']['general']['experience'] = $levelUp[$_SESSION['hero']['general']['level']]['cost'];
    }
}

//tweaks monst xp awarded based on level difference
function xpReward()
{
    global $monsterTypes, $monsterIndex;

    $levelDifference = $_SESSION['hero']['general']['level'] - $monsterTypes[$monsterIndex]['level'];

    // Default XP reward
    $xpReward = $monsterTypes[$monsterIndex]['experience'];

    // Adjust XP reward based on level difference using switch-case
    switch ($levelDifference) {
        case 1:
            $xpReward *= 1;
            break;
        case 2:
            $xpReward *= 0.9; // 90% of the original XP
            break;
        case 3:
            $xpReward *= 0.8; // 80% of the original XP
            break;
        case 4:
            $xpReward *= 0.7;
            break;
        case 5:
            $xpReward *= 0.5;
            break;
        default:
            if ($levelDifference > 5) {
                $xpReward *= 0.1;
            }
            break;
    }

    return floor($xpReward); // Round down the result if needed
}
//Tweaks monster gold-drop based on level difference
function goldReward()
{
    global $monsterTypes, $monsterIndex;

    $levelDifference = $_SESSION['hero']['general']['level'] - $monsterTypes[$monsterIndex]['level'];

    // Default XP reward
    $goldReward = $monsterTypes[$monsterIndex]['goldDrop'];

    // Adjust XP reward based on level difference using switch-case
    switch ($levelDifference) {
        case 1:
            $goldReward *= 1;
            break;
        case 2:
            $goldReward *= 0.9; // 90% of the original XP
            break;
        case 3:
            $goldReward *= 0.8; // 80% of the original XP
            break;
        case 4:
            $goldReward *= 0.7;
            break;
        case 5:
            $goldReward *= 0.5;
            break;
        default:
            if ($levelDifference > 5) {
                $goldReward *= 0.1;
            }
            break;
    }

    return floor($goldReward);
}

//Similar to regenerateStamina, regenerates HP based on time difference between time()
//and last time since update. Values for regenRate are initialised at initialiseHero.php.
function regenerateHP()
{
    $currentTime = time();
    $lastHPupdate = $_SESSION['hero']['resource']['lastHPupdate'];
    $elapsedTime = $currentTime - $lastHPupdate;

    $hpRegenRate = $_SESSION['hero']['resource']['hpRegenRate'];
    $regenAmount = floor($elapsedTime / 60) * $hpRegenRate;

    $_SESSION['hero']['resource']['hitpoints'] = min($_SESSION['hero']['resource']['hitpointsMax'], $_SESSION['hero']['resource']['hitpoints'] + $regenAmount);

    // Update the timestamp of the last HP update
    $_SESSION['hero']['resource']['lastHPupdate'] = $currentTime;
}

function regenerateStamina()
{
    $currentTime = time();
    $lastStaminaUpdate = $_SESSION['hero']['resource']['lastStaminaUpdate'];
    $elapsedTime = $currentTime - $lastStaminaUpdate;

    // Calculate the amount of stamina to regenerate based on the regeneration rate
    $staminaRegenRate = $_SESSION['hero']['resource']['staminaRegenRate'];
    $regenAmount = floor($elapsedTime / 60) * $staminaRegenRate; // 5 units per minute

    // Update stamina, ensuring it doesn't exceed the maximum
    $_SESSION['hero']['resource']['stamina'] = min($_SESSION['hero']['resource']['staminaMax'], $_SESSION['hero']['resource']['stamina'] + $regenAmount);

    // Update the timestamp of the last stamina update
    $_SESSION['hero']['resource']['lastStaminaUpdate'] = $currentTime;
}

//Calls regenHP and Stamina if 3+ minutes have passed since last update.
function checkRegenerationTime()
{

    if (isset($_SESSION['hero']) && time() - $_SESSION['hero']['resource']['lastStaminaUpdate'] >= 180) {
        regenerateStamina();
        regenerateHP();
    }
}

function noNegativeStamina()
{
    if ($_SESSION['hero']['resource']['stamina'] < 0) {
        $_SESSION['hero']['resource']['stamina'] = 0;
    }
}

//resolves combat, counts number of turns and subtracts player-Grit(stamina)
function doBattle($playerRetreat)
{
    global $monsterTypes, $monsterIndex, $initiative, $combatLog, $staminaCost;
    $turnCounter = 1;

    $playerRetreat = $playerRetreat / 100 * $_SESSION['hero']['resource']['hitpointsMax'];

    do {

        if (combatInitiative() == true) {
            array_push($combatLog, "<strong>Turn " . $turnCounter . ": </strong>" . $initiative . " goes first!");
            playerAttack();
            if ($monsterTypes[$monsterIndex]['hitpoints'] > 0) {
                monsterAttack();
            }
        } else {
            array_push($combatLog, "<strong>Turn " . $turnCounter . ": </strong>" . $initiative . " goes first!");
            monsterAttack();
            if ($_SESSION['hero']['resource']['hitpoints'] > $playerRetreat) {
                playerAttack();
            }
        }
        if ($monsterTypes[$monsterIndex]['hitpoints'] <= 0) {
            $xpReward = xpReward();
            $goldReward = goldReward();
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " is slain!");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['general']['name'] . " earned " . $xpReward . " xp!</strong>");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['general']['name'] . " was rewarded " . $goldReward . " gold!</strong>");
            $_SESSION['hero']['general']['experience'] = $_SESSION['hero']['general']['experience'] + $xpReward;
            $_SESSION['hero']['general']['gold'] = $_SESSION['hero']['general']['gold'] + $goldReward;
            break;
        } elseif ($_SESSION['hero']['resource']['hitpoints'] <= 0) {
            array_push($combatLog, $_SESSION['hero']['general']['name'] . " is slain!");
        } elseif ($_SESSION['hero']['resource']['hitpoints'] <= $playerRetreat) {
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " wins!");
        }

        $turnCounter++;
        $staminaCost = $turnCounter;
    } while ($_SESSION['hero']['resource']['hitpoints'] > $playerRetreat);
    //reduce hero Grit = number of turns.
    $_SESSION['hero']['resource']['stamina'] -= $staminaCost;
    noNegativeStamina();
}

//applies the effect of key => healing items bought in the store.
function applyHealingItemEffects()
{
    global $itemShopArray;
    foreach ($itemShopArray as $valueType) {
        $_SESSION['hero']['resource']['hitpoints'] += $valueType['hitpoints'];
        if ($_SESSION['hero']['resource']['hitpoints'] > $_SESSION['hero']['resource']['hitpointsMax']) {
            $_SESSION['hero']['resource']['hitpoints'] = $_SESSION['hero']['resource']['hitpointsMax'];
        }
    }
}

//applies Trinket item effects, also ensures the player can only buy one of each.
function applyTrinketItemEffects()
{
    global $itemShopArray;
    foreach ($itemShopArray as $category => $item) {
        if ($category === "trinkets" && isset($item['evasion'])) {
            $evasionIncrease = $item['evasion'];

            if (isset($_SESSION['hero']['evasion'])) {
                $_SESSION['hero']['combat']['evasion'] += $evasionIncrease;
                array_push($_SESSION['hero']['nventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
        if ($category === "trinkets" && isset($item['hitpointsMax'])) {
            $maxHPincrease = $item['hitpointsMax'];

            if (isset($_SESSION['hero']['resource']['hitpointsMax'])) {
                $_SESSION['hero']['resource']['hitpointsMax'] += $maxHPincrease;
                array_push($_SESSION['hero']['inventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
        if ($category === "trinkets" && isset($item['chanceToHit'])) {
            $incToHit = $item['chanceToHit'];

            if (isset($_SESSION['hero']['combat']['chanceToHit'])) {
                $_SESSION['hero']['combat']['chanceToHit'] += $incToHit;
                array_push($_SESSION['hero']['inventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
    }
}

//subtracts added weapon bonuses from the player, used when switching weapons.
function removeWeaponBonuses()
{
    $_SESSION['hero']['combat']['initiative'] -= $_SESSION['hero']['weapon']['initiative'];
    if (in_array('evasion', $_SESSION['hero']['weapon'])) {
        $_SESSION['hero']['combat']['evasion'] -= $_SESSION['hero']['weapon']['evasion'];
    }
}

//adds weapon bonuses to the player, used when switching weapons.
function addWeaponBonuses()
{
    $_SESSION['hero']['combat']['initiative'] += $_SESSION['hero']['weapon']['initiative'];
    if (in_array('evasion', $_SESSION['hero']['weapon'])) {
        $_SESSION['hero']['combat']['evasion'] += $_SESSION['hero']['weapon']['evasion'];
    }
}

//removes armour bonuses from the player, used when switching armour.
function removeArmourBonuses()
{
    $_SESSION['hero']['combat']['evasion'] -= $_SESSION['hero']['armour']['evasion'];
    $_SESSION['hero']['combat']['absorb'] -= $_SESSION['hero']['armour']['absorb'];
}
//adds armour bonuses to the player, used when switching armour.
function addArmourBonuses()
{
    $_SESSION['hero']['combat']['evasion'] += $_SESSION['hero']['armour']['evasion'];
    $_SESSION['hero']['combat']['absorb'] += $_SESSION['hero']['armour']['absorb'];
}

//applies new weapon stats to player, and updates total (base + weapon) values accordingly.
function applyWeaponItemEffects()
{
    global $itemShopArray;
    foreach ($itemShopArray as $category => $item) {
        if ($category === "weapons") {
            removeWeaponBonuses();
            $_SESSION['hero']['weapon']['name'] = $item['name'];
            $_SESSION['hero']['weapon']['damage'] = $item['damage'];
            $_SESSION['hero']['weapon']['initiative'] = $item['initiative'];
            if (isset($item['evasion'])) {
                $_SESSION['hero']['weapon']['evasion'] = $item['evasion'];
            } else {
                $_SESSION['hero']['weapon']['evasion'] = $item['evasion'];
            }
            addWeaponBonuses();
        }
    }
}

function applyArmourItemEffects()
{
    global $itemShopArray;
    foreach ($itemShopArray as $category => $item) {
        if ($category === "armour") {
            removeArmourBonuses();
            $_SESSION['hero']['armour']['name'] = $item['name'];
            $_SESSION['hero']['armour']['evasion'] = $item['evasion'];
            $_SESSION['hero']['armour']['absorb'] = $item['absorb'];
            addArmourBonuses();
        }
    }
}

//Changes displayed Key-value in the Shop (foreach-loop),
//where array-key does not match the in-game description.
function getDisplayKey($key)
{
    switch ($key) {
        case 'cost':
            return 'Gold';
        case 'hitpoints':
            return 'Gain HP';
        case 'absorb':
            return 'Damage Reduction';
        case 'hitpointsMax':
            return 'Increase Max HP';
        case 'chanceToHit':
            return 'Chance to Hit';
        default:
            return $key;
    }
}

function getPlayerGender()
{
    switch ($_SESSION['hero']['general']['gender']) {
        case 'male':
            $genderPronoun = 'his';
            break;
        case 'female':
            $genderPronoun = 'her';
            break;

        default:
            $genderPronoun = 'their';
            break;
    }
    return $genderPronoun;
}

//checks username availability on new user registration.
function isUsernameAvailable($username, $pdo)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch the count
    $count = $stmt->fetchColumn();

    // If count is 0, the username is available; otherwise, it's already taken
    return $count === 0;
}

function savePlayerProgress()
{
    // Check conditions
    if (isset($_SESSION['user_id']) && $_SESSION['hero']['resource']['hitpoints'] > 0) {
        deletePlayerData();
        writePlayerData();
    }
}

function deletePlayerData()
{
    global $db;
    try {
        // Prepare and execute the DELETE statement
        $stmt = $db->prepare('DELETE FROM playerHero WHERE user_id = :userID');
        $stmt->bindParam(':userID', $_SESSION['user_id']);
        $stmt->execute();

        // Output success message or perform other actions if needed
        //echo "Player data deleted successfully.";
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
}

function writePlayerData()
{
    global $db;

    $playerData = json_encode($_SESSION['hero']);
    $version = 1;

    try {

        $prepare = $db->prepare('INSERT INTO playerHero (user_id, playerHero_data, version)
        VALUES (:userID, :heroData, :version)');

        $prepare->bindParam(':userID', $_SESSION['user_id']);
        $prepare->bindParam(':heroData', $playerData);
        $prepare->bindParam(':version', $version);
        $prepare->execute();
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
}
