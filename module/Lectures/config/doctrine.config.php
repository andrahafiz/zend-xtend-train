<?php
return [
    'doctrine' => [
        'driver' => [
            'lectures_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Lectures\Entity' => 'lectures_entity',
                ]
            ]
        ],
    ],
];
