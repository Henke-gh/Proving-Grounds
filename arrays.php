<?php

$player = [
    'name' => 'Hero',
    'gender' => 'Unknown',
    'avatar' => 0,
    'level' => 1,
    'hitpointsMax' => 10,
    'hitpoints' => 10,
    'initiative' => 5,
    'chanceToHit' => 7,
    'chanceToCrit' => 10,
    'evasion' => 3,
    'weapon' => [
        'name' => 'Wooden Sword',
        'damage' => 2,
        'initiative' => 1
    ],
    'experience' => 0,
    'gold' => 0,
];

$combatLog = [];

$itemEffectsMapping = [
    'hitpoints' => 'hitpoints',
    'damage' => 'damage',
    'initiative' => 'initiative',
    'absorb' => 'absorb',
    'evasion' => 'evasion',
    'hitpointsMax' => 'hitpointsMax',
];

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
        'name' => 'Long Staff',
        'damage' => 3,
        'initiative' => 4
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
    ],
    'weapons' => [
        [
            'name' => 'War Axe',
            'damage' => 6,
            'initiative' => 3,
            'cost' => 35,
        ],
    ],
    'armour' => [
        [
            'name' => 'Gladiator Breastplate',
            'absorb' => 3,
            'evasion' => -2,
            'cost' => 550,
        ],
        [
            'name' => 'Ranger Mantle',
            'absorb' => 0,
            'evasion' => 5,
            'cost' => 500,
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
    ],
];

$monsterTypes = [
    [
        'name' => 'Skeleton Knight',
        'hitpoints' => 8,
        'initiative' => 5,
        'chanceToHit' => 4,
        'chanceToCrit' => 5,
        'evasion' => 1,
        'weapon' => [
            'name' => 'Long Sword',
            'damage' => 4
        ],
        'experience' => 10,
        'goldDrop' => 20,
    ],
    [
        'name' => 'Skeletal Priest',
        'hitpoints' => 6,
        'initiative' => 4,
        'chanceToHit' => 4,
        'chanceToCrit' => 4,
        'evasion' => 0,
        'weapon' => [
            'name' => 'Cane',
            'damage' => 3
        ],
        'experience' => 5,
        'goldDrop' => 15,
    ],
    [
        'name' => 'Scabby Ratman',
        'hitpoints' => 7,
        'initiative' => 9,
        'chanceToHit' => 6,
        'chanceToCrit' => 7,
        'evasion' => 3,
        'weapon' => [
            'name' => 'Rusty Dagger',
            'damage' => 2
        ],
        'experience' => 10,
        'goldDrop' => 20,
    ],
    [
        'name' => 'Young Troll',
        'hitpoints' => 16,
        'initiative' => 5,
        'chanceToHit' => 5,
        'chanceToCrit' => 4,
        'evasion' => 0,
        'weapon' => [
            'name' => 'Stone Axe',
            'damage' => 4
        ],
        'experience' => 15,
        'goldDrop' => 25,
    ],
    [
        'name' => 'Legionnaire Lancer',
        'hitpoints' => 12,
        'initiative' => 8,
        'chanceToHit' => 6,
        'chanceToCrit' => 6,
        'evasion' => 3,
        'weapon' => [
            'name' => 'War Javelin',
            'damage' => 6
        ],
        'experience' => 20,
        'goldDrop' => 30,
    ],
    [
        'name' => "Chthonian Nightmare",
        'hitpoints' => 85,
        'initiative' => 10,
        'chanceToHit' => 8,
        'chanceToCrit' => 20,
        'evasion' => 5,
        'weapon' => [
            'name' => 'Slithering Tentacle',
            'damage' => 15
        ],
        'experience' => 85,
        'goldDrop' => 50,
    ],
    [
        'name' => 'XP Goblin',
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
];

$avatars = [
    ['url' => '/assets/images/avatar_male01t.png'],
    ['url' => '/assets/images/avatar_fem01t.png'],
    ['url' => '/assets/images/avatar_fem02t.png'],
    ['url' => '/assets/images/avatar_male02t.png'],
];
