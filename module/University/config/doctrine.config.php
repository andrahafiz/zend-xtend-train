<?php
return [
    'doctrine' => [
        'driver' => [
            'university_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'University\Entity' => 'university_entity',
                ]
            ]
        ],
    ],
];
