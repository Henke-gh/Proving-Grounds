<?php
require_once __DIR__ . "/functions/startSession.php";
require_once __DIR__ . "/nav/header.html";
checkRegenerationTime();
?>
<main>
    <div class="aboutPageContainer">
        <h1>Game Guide</h1>
        <article>
            <h3>Character stats</h3>
            <p>Your Hero has a number of different stats. Here's a short breakdown of
                some of the ones you see displayed.</p>
            <h3>Hitpoints or HP</h3>
            <p>You know this one. Loose em all and you're dead. Can be replenished by
                various means, bandages being one. Try the shop. You also heal for a small amount
                over time, though not as quickly as Grit recovers.</p>
            <h3>Grit</h3>
            <p>Grit is the new stamina. It depletes during actions taken, such as combat.
                It regenerates naturally over time after a few minutes, reload a page or switch between pages
                if it hasn't in some time. At zero Grit
                your Hero can't fight, clean the bar or perform other (coming soon™) demanding tasks.</p>
            <h3>Fame</h3>
            <p>It's a measure of your renown, glory and splendour! As it increases your
                characters title changes to reflect your growing.. well, fame.
            </p>
            <h3>Experience or XP</h3>
            <p>No surprises here. Gained by slapping monsters in the face. Get enough and you
                level up. Leveling up grants +5 max HP, replenished life and Grit, an increase in fame and a bonus to one of two additional stats.
                Sweet! Did I mention you get gold? You get some gold too.</p>
            <h3>Initiative</h3>
            <p>This is a measure of how quick your Hero is and affects whether you get to
                act first on any particular turn during combat.</p>
            <h3>Chance to Hit</h3>
            <p>Your chance to hit determines if your hits in combat connect or not. This stat
                is counteracted by the defensive stat Evasion.</p>
            <h3>Critical Strike Chance</h3>
            <p>Does what it says on the tin. When you score a crit you deal increased damage. Beware,
                most monsters are able to aswell!</p>
            <h3>Evasion</h3>
            <p>Evasion is a defensive stat that reduces the likelihood of getting hit in combat. Flow
                like water and all that.</p>
            <h3>Damage Reduction</h3>
            <p>This stat flat out negates or absorbs a portion of damage taken equal to its value.
                Though it will often come at the price of reduced Evasion.</p>
        </article>
        <img src="/assets/images/crossing_swords.png">
    </div>
</main>

<?php

require_once __DIR__ . "/nav/footer.php";
