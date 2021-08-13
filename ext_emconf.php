<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'RSS Feed Display',
    'description' => 'Fetch a RSS / Atom Feed and display its content on the Frontend.',
    'category' => 'plugin',
    'version' => '5.1.0-dev',
    'state' => 'stable',
    'author' => 'Fabien Udriot',
    'author_email' => 'fabien@ecodev.ch',
    'author_company' => 'Ecodev',
    'autoload' => [
        'psr-4' => ['Fab\\RssDisplay\\' => 'Classes']
    ],
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '10.4.0-10.4.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];
