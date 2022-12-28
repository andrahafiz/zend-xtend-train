<?php
return [
    'service_manager' => [
        'factories' => [
            \Student\V1\Rest\Student\StudentResource::class => \Student\V1\Rest\Student\StudentResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'student.rest.student' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/V1/student[/:uuid]',
                    'defaults' => [
                        'controller' => 'Student\\V1\\Rest\\Student\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'student.rest.student',
        ],
    ],
    'zf-rest' => [
        'Student\\V1\\Rest\\Student\\Controller' => [
            'listener' => \Student\V1\Rest\Student\StudentResource::class,
            'route_name' => 'student.rest.student',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'student',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Student\\Entity\\Student',
            'collection_class' => \Student\V1\Rest\Student\StudentCollection::class,
            'service_name' => 'Student',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Student\\V1\\Rest\\Student\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Student\\V1\\Rest\\Student\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Student\\V1\\Rest\\Student\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Student\V1\Rest\Student\StudentEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'student.rest.student',
                'route_identifier_name' => 'student_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Student\V1\Rest\Student\StudentCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'student.rest.student',
                'route_identifier_name' => 'student_id',
                'is_collection' => true,
            ],
            'Student\\Entity\\Student' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'student.rest.student',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
        ],
    ],
];
