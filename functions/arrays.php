<?php

$player = [
    'name' => 'Hero',
    'gender' => 'Unknown',
    'avatar' => 0,
    'level' => 1,
    'fame' => 0,
    'fameLevel' => 0,
    'fameTitle' => 'Novice',
    'hitpointsMax' => 10,
    'hitpoints' => 10,
    'stamina' => 100,
    'staminaMax' => 100,
    'initiative' => 3,
    'chanceToHit' => 7,
    'chanceToCrit' => 10,
    'evasion' => 3,
    'absorb' => 0,
    'weapon' => [
        'name' => 'Wooden Sword',
        'damage' => 2,
        'initiative' => 1,
        'evasion' => 0,
    ],
    'armour' => [
        'name' => 'Tunic',
        'evasion' => 0,
        'absorb' => 0
    ],
    'experience' => 0,
    'gold' => 0,
];

$playerInventory = [];

$combatLog = [];

$startingWeapons = [
    [
        'name' => 'Short Sword',
        'damage' => 4,
        'initiative' => 2
    ],
    [
        'name' => 'Unwieldy Club',
        'damage' => 5,
        'initiative' => 0
    ],
    [
        'name' => 'Wooden Staff',
        'damage' => 3,
        'initiative' => 4,
        'evasion' => 2
    ]
];

$vendorItems = [
    'healing' => [
        [
            'name' => 'Bandages',
            'hitpoints' => 5,
            'cost' => 10
        ],
        [
            'name' => 'Elixir of Life',
            'hitpoints' => 10,
            'cost' => 20
        ],
        [
            'name' => 'Murahan Salve',
            'hitpoints' => 20,
            'cost' => 35
        ],
        [
            'name' => 'Sanctified Tea',
            'hitpoints' => 40,
            'cost' => 70
        ],
    ],
    'weapons' => [
        [
            'name' => 'Blade-Staff',
            'damage' => 6,
            'initiative' => 4,
            'cost' => 350,
        ],
        [
            'name' => 'Twin Daggers',
            'damage' => 5,
            'evasion' => 4,
            'initiative' => 4,
            'cost' => 300,
        ],
        [
            'name' => 'War Axe',
            'damage' => 8,
            'initiative' => 1,
            'cost' => 450,
        ],
        [
            'name' => 'Bastard Sword',
            'damage' => 10,
            'initiative' => 5,
            'cost' => 1200,
        ],
    ],
    'armour' => [
        [
            'name' => 'Mercenary Garb',
            'absorb' => 1,
            'evasion' => 1,
            'cost' => 200,
        ],
        [
            'name' => 'Ranger Mantle',
            'absorb' => 0,
            'evasion' => 3,
            'cost' => 400,
        ],
        [
            'name' => 'Gladiator Breastplate',
            'absorb' => 4,
            'evasion' => -2,
            'cost' => 550,
        ],
    ],
    'trinkets' => [
        [
            'name' => 'Jade Amulet',
            'evasion' => 4,
            'cost' => 1000,
        ],
        [
            'name' => 'Stone of Brawn',
            'hitpointsMax' => 10,
            'cost' => 800,
        ],
        [
            'name' => 'Engraved Medal',
            'chanceToHit' => 2,
            'cost' => 650,
        ],
    ],
];

$monsterTypes = [
    [
        'name' => 'Cowardly Cultist',
        'level' => 1,
        'hitpoints' => 6,
        'initiative' => 4,
        'chanceToHit' => 5,
        'chanceToCrit' => 4,
        'evasion' => 0,
        'weapon' => [
            'name' => 'Cane',
            'damage' => 3
        ],
        'experience' => 10,
        'goldDrop' => 15,
    ],
    [
        'name' => 'Bandit',
        'level' => 2,
        'hitpoints' => 9,
        'initiative' => 5,
        'chanceToHit' => 6,
        'chanceToCrit' => 5,
        'evasion' => 1,
        'weapon' => [
            'name' => 'Crooked Sword',
            'damage' => 4
        ],
        'experience' => 15,
        'goldDrop' => 25,
    ],
    [
        'name' => 'Scabby Goblin',
        'level' => 2,
        'hitpoints' => 8,
        'initiative' => 9,
        'chanceToHit' => 8,
        'chanceToCrit' => 7,
        'evasion' => 3,
        'weapon' => [
            'name' => 'Rusty Dagger',
            'damage' => 3
        ],
        'experience' => 15,
        'goldDrop' => 25,
    ],
    [
        'name' => 'Young Troll',
        'level' => 4,
        'hitpoints' => 16,
        'initiative' => 5,
        'chanceToHit' => 6,
        'chanceToCrit' => 4,
        'evasion' => 0,
        'weapon' => [
            'name' => 'Stone Axe',
            'damage' => 10
        ],
        'experience' => 20,
        'goldDrop' => 30,
    ],
    [
        'name' => 'Bandit Thug',
        'level' => 4,
        'hitpoints' => 12,
        'initiative' => 5,
        'chanceToHit' => 9,
        'chanceToCrit' => 5,
        'evasion' => 3,
        'weapon' => [
            'name' => 'Long Sword',
            'damage' => 5
        ],
        'experience' => 20,
        'goldDrop' => 30,
    ],
    [
        'name' => 'Veteran Legionnaire',
        'level' => 6,
        'hitpoints' => 14,
        'initiative' => 8,
        'chanceToHit' => 11,
        'chanceToCrit' => 6,
        'evasion' => 3,
        'weapon' => [
            'name' => 'War Javelin',
            'damage' => 6
        ],
        'experience' => 25,
        'goldDrop' => 35,
    ],
    [
        'name' => 'Angvarian Bull',
        'level' => 6,
        'hitpoints' => 16,
        'initiative' => 5,
        'chanceToHit' => 8,
        'chanceToCrit' => 5,
        'evasion' => 5,
        'weapon' => [
            'name' => 'Horns',
            'damage' => 8
        ],
        'experience' => 25,
        'goldDrop' => 35,
    ],
    [
        'name' => 'Monk of Zhe',
        'level' => 8,
        'hitpoints' => 21,
        'initiative' => 7,
        'chanceToHit' => 13,
        'chanceToCrit' => 5,
        'evasion' => 4,
        'weapon' => [
            'name' => 'Twin Sickles',
            'damage' => 8
        ],
        'experience' => 40,
        'goldDrop' => 40,
    ],
    [
        'name' => "Chthonian Nightmare",
        'level' => 15,
        'hitpoints' => 85,
        'initiative' => 10,
        'chanceToHit' => 15,
        'chanceToCrit' => 20,
        'evasion' => 5,
        'weapon' => [
            'name' => 'Slithering Tentacle',
            'damage' => 15
        ],
        'experience' => 85,
        'goldDrop' => 60,
    ],
    [
        'name' => 'XP Goblin',
        'level' => 99,
        'hitpoints' => 1,
        'initiative' => 1,
        'chanceToHit' => 1,
        'chanceToCrit' => 0,
        'evasion' => 0,
        'weapon' => [
            'name' => 'Bucket of Experience',
            'damage' => 0
        ],
        'experience' => 100,
        'goldDrop' => 300,
    ],
];

$fameTitle = [
    [
        'fame' => 0,
        'title' => 'Novice'
    ],
    [
        'fame' => 10,
        'title' => 'Adventuring Combatant'
    ],
    [
        'fame' => 25,
        'title' => 'Gladiator'
    ],
    [
        'fame' => 50,
        'title' => 'Ferocious Fighter'
    ],
    [
        'fame' => 75,
        'title' => 'Champion'
    ],
    [
        'fame' => 100,
        'title' => 'Anointed War-Bringer'
    ],
];

$levelUp = [
    [
        'level' => 1,
        'cost' => 0
    ],
    [
        'level' => 2,
        'cost' => 50
    ],
    [
        'level' => 3,
        'cost' => 100
    ],
    [
        'level' => 4,
        'cost' => 150
    ],
    [
        'level' => 5,
        'cost' => 200
    ],
    [
        'level' => 6,
        'cost' => 300
    ],
    [
        'level' => 7,
        'cost' => 400
    ],
    [
        'level' => 8,
        'cost' => 500
    ],
    [
        'level' => 9,
        'cost' => 750
    ],
    [
        'level' => 10,
        'cost' => 1000
    ],
    [
        'level' => 11,
        'cost' => 1250
    ],
    [
        'level' => 12,
        'cost' => 1500
    ],
    [
        'level' => 13,
        'cost' => 1750
    ],
    [
        'level' => 14,
        'cost' => 2500
    ],
    [
        'level' => 15,
        'cost' => 3500
    ],
];

$avatars = [
    ['url' => '/assets/images/avatar_male01t.png'],
    ['url' => '/assets/images/avatar_fem01t.png'],
    ['url' => '/assets/images/avatar_fem02t.png'],
    ['url' => '/assets/images/avatar_male02t.png'],
];
