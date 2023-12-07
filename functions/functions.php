<?php

function combatInitiative()
{
    global $monsterTypes, $monsterIndex, $initiative;
    if ($_SESSION['hero']['initiative'] >= $monsterTypes[$monsterIndex]['initiative']) {
        if ($_SESSION['hero']['initiative'] < toHitValue()) {
            $initiative = $monsterTypes[$monsterIndex]['name'];
            return false;
        } else {
            $initiative = $_SESSION['hero']['name'];
            return true;
        }
    } elseif ($monsterTypes[$monsterIndex]['initiative'] < toHitValue()) {
        $initiative = $_SESSION['hero']['name'];
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
    $toHit = rand(1, 10) + $_SESSION['hero']['evasion'];
    return $toHit;
}

function playerAttack()
{
    global $monsterTypes, $monsterIndex, $combatLog, $criticalDamage;

    $criticalDamage = $_SESSION['hero']['weapon']['damage'] * 1.5;
    $damage = $_SESSION['hero']['weapon']['damage'];
    if ($damage < 0) {
        $damage = 0;
    }
    $critChance = $_SESSION['hero']['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $_SESSION['hero']['name'] . " charges with " . getPlayerGender() . " " . $_SESSION['hero']['weapon']['name'] . "!");
    if ($critChance >= $toCrit) {
        array_push($combatLog, $_SESSION['hero']['name'] . " delivers a crushing blow to " . $monsterTypes[$monsterIndex]['name'] . " for<strong> " . floor($criticalDamage) . " damage!</strong>");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - floor($criticalDamage);
    } elseif ($_SESSION['hero']['chanceToHit'] < toHitValuePlayer()) {
        array_push($combatLog, $_SESSION['hero']['name'] . " missed..");
    } else {
        array_push($combatLog, $_SESSION['hero']['name'] . " hits " . $monsterTypes[$monsterIndex]['name'] . " for " . $damage . " damage!");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - $damage;
    }
};

function monsterAttack()
{
    global $monsterTypes, $monsterIndex, $combatLog, $criticalDamage;

    $criticalDamage = $monsterTypes[$monsterIndex]['weapon']['damage'] * 1.5;
    $damage = $monsterTypes[$monsterIndex]['weapon']['damage'] - $_SESSION['hero']['absorb'];
    //negative damage values causes that which is hit to gain HP and it's all sorts of bad...
    if ($damage < 0) {
        $damage = 0;
    }
    $critChance = $monsterTypes[$monsterIndex]['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " swings its " . $monsterTypes[$monsterIndex]['weapon']['name'] . "!");
    if ($critChance >= $toCrit) {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " strikes a murderous blow to " . $_SESSION['hero']['name'] . " for <strong>" . floor($criticalDamage) . " damage!</strong>");
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpoints'] - floor($criticalDamage);
    } elseif ($monsterTypes[$monsterIndex]['chanceToHit'] < toHitValueMonster()) {
        array_push($combatLog, "Phew, " . $monsterTypes[$monsterIndex]['name'] . " missed..");
    } else {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " hits " . $_SESSION['hero']['name'] . " for " . $damage . " damage!");
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpoints'] - $damage;
    }
}

function heroDeath()
{
    if (isset($_SESSION['hero']) && $_SESSION['hero']['hitpoints'] <= 0) {
        header('Location: graveyard.php');
    }
}

//If player level is dividable by 2: Add +1 chance to hit, else add +1 Evasion.
function checkToAddEvasionOrHitChance($level)
{
    if ($level % 2 == 0) {
        $_SESSION['hero']['chanceToHit'] = $_SESSION['hero']['chanceToHit'] + 1;
        array_push($_SESSION['levelUpMsg'], "You gain +1 Chance to Hit.");
    } else {
        $_SESSION['hero']['evasion'] = $_SESSION['hero']['evasion'] + 1;
        array_push($_SESSION['levelUpMsg'], "You gain +1 Evasion.");
    }
}

function levelUp()
{
    global $levelUp, $fameTitle;

    $newFameLevel = $_SESSION['hero']['fameLevel'] + 1;

    if ($_SESSION['hero']['experience'] >= $levelUp[$_SESSION['hero']['level']]['cost']) {
        $_SESSION['levelUpMsg'] = [];
        $_SESSION['hero']['level'] = $_SESSION['hero']['level'] + 1;
        $_SESSION['hero']['fame'] = $_SESSION['hero']['fame'] + 5;
        if ($_SESSION['hero']['fame'] >= $fameTitle[$newFameLevel]['fame']) {
            $_SESSION['hero']['fameLevel'] = $_SESSION['hero']['fameLevel'] + 1;
            $_SESSION['hero']['fameTitle'] = $fameTitle[$_SESSION['hero']['fameLevel']]['title'];
        }
        $_SESSION['hero']['hitpointsMax'] = $_SESSION['hero']['hitpointsMax'] + 5;
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpointsMax'];
        $_SESSION['hero']['stamina'] = $_SESSION['hero']['staminaMax'];
        $_SESSION['hero']['gold'] += 75;
        array_push($_SESSION['levelUpMsg'], "You gain +5 Max HP.");
        array_push($_SESSION['levelUpMsg'], "You gain +5 Fame.");
        checkToAddEvasionOrHitChance($_SESSION['hero']['level']);
        array_push($_SESSION['levelUpMsg'], "You earn 75 gold!");
    }
}

//tweaks monst xp awarded based on level difference
function xpReward()
{
    global $monsterTypes, $monsterIndex;

    $levelDifference = $_SESSION['hero']['level'] - $monsterTypes[$monsterIndex]['level'];

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

    $levelDifference = $_SESSION['hero']['level'] - $monsterTypes[$monsterIndex]['level'];

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
    $lastHPupdate = $_SESSION['hero']['lastHPupdate'];
    $elapsedTime = $currentTime - $lastHPupdate;

    $hpRegenRate = $_SESSION['hero']['hpRegenRate'];
    $regenAmount = floor($elapsedTime / 60) * $hpRegenRate;

    $_SESSION['hero']['hitpoints'] = min($_SESSION['hero']['hitpointsMax'], $_SESSION['hero']['hitpoints'] + $regenAmount);

    // Update the timestamp of the last HP update
    $_SESSION['hero']['lastHPupdate'] = $currentTime;
}

function regenerateStamina()
{
    $currentTime = time();
    $lastStaminaUpdate = $_SESSION['hero']['lastStaminaUpdate'];
    $elapsedTime = $currentTime - $lastStaminaUpdate;

    // Calculate the amount of stamina to regenerate based on the regeneration rate
    $staminaRegenRate = $_SESSION['hero']['staminaRegenRate'];
    $regenAmount = floor($elapsedTime / 60) * $staminaRegenRate; // 5 units per minute

    // Update stamina, ensuring it doesn't exceed the maximum
    $_SESSION['hero']['stamina'] = min($_SESSION['hero']['staminaMax'], $_SESSION['hero']['stamina'] + $regenAmount);

    // Update the timestamp of the last stamina update
    $_SESSION['hero']['lastStaminaUpdate'] = $currentTime;
}

//Runs regenHP and Stamina if 3+ minutes have passed since last update.
function checkRegenerationTime()
{

    if (isset($_SESSION['hero']) && time() - $_SESSION['hero']['lastStaminaUpdate'] >= 180) {
        regenerateStamina();
        regenerateHP();
    }
}

function noNegativeStamina()
{
    if ($_SESSION['hero']['stamina'] < 0) {
        $_SESSION['hero']['stamina'] = 0;
    }
}

function doBattle($playerRetreat)
{
    global $monsterTypes, $monsterIndex, $initiative, $combatLog, $staminaCost;
    $turnCounter = 1;

    $playerRetreat = $playerRetreat / 100 * $_SESSION['hero']['hitpointsMax'];

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
            if ($_SESSION['hero']['hitpoints'] > $playerRetreat) {
                playerAttack();
            }
        }
        if ($monsterTypes[$monsterIndex]['hitpoints'] <= 0) {
            $xpReward = xpReward();
            $goldReward = goldReward();
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " is slain!");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['name'] . " earned " . $xpReward . " xp!</strong>");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['name'] . " was rewarded " . $goldReward . " gold!</strong>");
            $_SESSION['hero']['experience'] = $_SESSION['hero']['experience'] + $xpReward;
            $_SESSION['hero']['gold'] = $_SESSION['hero']['gold'] + $goldReward;
            break;
        } elseif ($_SESSION['hero']['hitpoints'] <= 0) {
            array_push($combatLog, $_SESSION['hero']['name'] . " is slain!");
        } elseif ($_SESSION['hero']['hitpoints'] <= $playerRetreat) {
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " wins!");
        }

        $turnCounter++;
        $staminaCost = $turnCounter;
    } while ($_SESSION['hero']['hitpoints'] > $playerRetreat);
    //reduce hero Grit = number of turns.
    $_SESSION['hero']['stamina'] -= $staminaCost;
    noNegativeStamina();
}

//applies the effect of key => healing items bought in the store.
function applyHealingItemEffects()
{
    global $itemShopArray;
    foreach ($itemShopArray as $valueType) {
        $_SESSION['hero']['hitpoints'] += $valueType['hitpoints'];
        if ($_SESSION['hero']['hitpoints'] > $_SESSION['hero']['hitpointsMax']) {
            $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpointsMax'];
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
                $_SESSION['hero']['evasion'] += $evasionIncrease;
                array_push($_SESSION['heroInventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
        if ($category === "trinkets" && isset($item['hitpointsMax'])) {
            $maxHPincrease = $item['hitpointsMax'];

            if (isset($_SESSION['hero']['hitpointsMax'])) {
                $_SESSION['hero']['hitpointsMax'] += $maxHPincrease;
                array_push($_SESSION['heroInventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
        if ($category === "trinkets" && isset($item['chanceToHit'])) {
            $incToHit = $item['chanceToHit'];

            if (isset($_SESSION['hero']['chanceToHit'])) {
                $_SESSION['hero']['chanceToHit'] += $incToHit;
                array_push($_SESSION['heroInventory'], $item['name']);
            } /* else {
                Add error-handling
            } */
        }
    }
}

//subtracts added weapon bonuses from the player, used when switching weapons.
function removeWeaponBonuses()
{
    $_SESSION['hero']['initiative'] -= $_SESSION['hero']['weapon']['initiative'];
    $_SESSION['hero']['evasion'] -= $_SESSION['hero']['weapon']['evasion'];
}

//adds weapon bonuses to the player, used when switching weapons.
function addWeaponBonuses()
{
    $_SESSION['hero']['initiative'] += $_SESSION['hero']['weapon']['initiative'];
    $_SESSION['hero']['evasion'] += $_SESSION['hero']['weapon']['evasion'];
}

//removes armour bonuses from the player, used when switching armour.
function removeArmourBonuses()
{
    $_SESSION['hero']['evasion'] -= $_SESSION['hero']['armour']['evasion'];
    $_SESSION['hero']['absorb'] -= $_SESSION['hero']['armour']['absorb'];
}
//adds armour bonuses to the player, used when switching armour.
function addArmourBonuses()
{
    $_SESSION['hero']['evasion'] += $_SESSION['hero']['armour']['evasion'];
    $_SESSION['hero']['absorb'] += $_SESSION['hero']['armour']['absorb'];
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
    switch ($_SESSION['hero']['gender']) {
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
