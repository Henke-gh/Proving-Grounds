<?php

$combatLog = [];

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
    $toHit = rand(1, 10);
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
    $critChance = $_SESSION['hero']['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $_SESSION['hero']['name'] . " charges with their " . $_SESSION['hero']['weapon']['name'] . "!");
    if ($_SESSION['hero']['chanceToHit'] < toHitValuePlayer()) {
        array_push($combatLog, $_SESSION['hero']['name'] . " missed..");
    } elseif ($critChance >= $toCrit) {
        array_push($combatLog, $_SESSION['hero']['name'] . " delivers a crushing blow to " . $monsterTypes[$monsterIndex]['name'] . " for<strong> " . floor($criticalDamage) . " damage!</strong>");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - floor($criticalDamage);
    } else {
        array_push($combatLog, $_SESSION['hero']['name'] . " hits " . $monsterTypes[$monsterIndex]['name'] . " for " . $_SESSION['hero']['weapon']['damage'] . " damage!");
        $monsterTypes[$monsterIndex]['hitpoints'] = $monsterTypes[$monsterIndex]['hitpoints'] - $_SESSION['hero']['weapon']['damage'];
    }
};

function monsterAttack()
{
    global $monsterTypes, $monsterIndex, $combatLog, $criticalDamage;
    $criticalDamage = $monsterTypes[$monsterIndex]['weapon']['damage'] * 1.5;
    $critChance = $monsterTypes[$monsterIndex]['chanceToCrit'];
    $toCrit = rand(1, 100);

    array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " swings its " . $monsterTypes[$monsterIndex]['weapon']['name'] . "!");
    if ($monsterTypes[$monsterIndex]['chanceToHit'] < toHitValueMonster()) {
        array_push($combatLog, "Phew, " . $monsterTypes[$monsterIndex]['name'] . " missed..");
    } elseif ($critChance >= $toCrit) {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " strikes a murderous blow to " . $_SESSION['hero']['name'] . " for <strong>" . floor($criticalDamage) . " damage!</strong>");
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpoints'] - floor($criticalDamage);
    } else {
        array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " hits " . $_SESSION['hero']['name'] . " for " . $monsterTypes[$monsterIndex]['weapon']['damage'] . " damage!");
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpoints'] - $monsterTypes[$monsterIndex]['weapon']['damage'];
    }
}

function heroDeath()
{
    if (isset($_SESSION['hero']) && $_SESSION['hero']['hitpoints'] <= 0) {
        header('Location: graveyard.php');
    }
}

function levelUp()
{
    global $levelUp;

    if ($_SESSION['hero']['experience'] >= $levelUp[$_SESSION['hero']['level']]['cost']) {
        $_SESSION['hero']['level'] = $_SESSION['hero']['level'] + 1;
        $_SESSION['hero']['hitpointsMax'] = $_SESSION['hero']['hitpointsMax'] + 5;
        $_SESSION['hero']['hitpoints'] = $_SESSION['hero']['hitpointsMax'];

        $_SESSION['levelUpMsg'] = "Congrats, you've leveled up! You gain 5 max HP.";
    }
}

function doBattle($playerRetreat)
{
    global $monsterTypes, $monsterIndex, $initiative, $combatLog;
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
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " is slain!");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['name'] . " earned " . $monsterTypes[$monsterIndex]['experience'] . " xp!</strong>");
            array_push($combatLog, "<strong>" . $_SESSION['hero']['name'] . " was rewarded " . $monsterTypes[$monsterIndex]['goldDrop'] . " gold!</strong>");
            $_SESSION['hero']['experience'] = $_SESSION['hero']['experience'] + $monsterTypes[$monsterIndex]['experience'];
            $_SESSION['hero']['gold'] = $_SESSION['hero']['gold'] + $monsterTypes[$monsterIndex]['goldDrop'];
            break;
        } elseif ($_SESSION['hero']['hitpoints'] <= 0) {
            array_push($combatLog, $_SESSION['hero']['name'] . " is slain!");
        } elseif ($_SESSION['hero']['hitpoints'] <= $playerRetreat) {
            array_push($combatLog, $monsterTypes[$monsterIndex]['name'] . " wins!");
        }

        $turnCounter++;
    } while ($_SESSION['hero']['hitpoints'] > $playerRetreat);
}
