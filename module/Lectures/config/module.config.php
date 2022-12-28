<?php
return [
    'service_manager' => [
        'factories' => [
            \Lectures\V1\Rest\Schedule\ScheduleResource::class => \Lectures\V1\Rest\Schedule\ScheduleResourceFactory::class,
        ],
        'abstract_factories' => [
            0 => \Lectures\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'lectures.rest.schedule' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/schedule[/:uuid]',
                    'defaults' => [
                        'controller' => 'Lectures\\V1\\Rest\\Schedule\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'lectures.rest.schedule',
        ],
    ],
    'zf-rest' => [
        'Lectures\\V1\\Rest\\Schedule\\Controller' => [
            'listener' => \Lectures\V1\Rest\Schedule\ScheduleResource::class,
            'route_name' => 'lectures.rest.schedule',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'schedule',
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
            'entity_class' => 'Lectures\\Entity\\Schedule',
            'collection_class' => \Lectures\V1\Rest\Schedule\ScheduleCollection::class,
            'service_name' => 'Schedule',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Lectures\\V1\\Rest\\Schedule\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Lectures\\V1\\Rest\\Schedule\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
        ],
        'content_type_whitelist' => [
            'Lectures\\V1\\Rest\\Schedule\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Lectures\V1\Rest\Schedule\ScheduleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'lectures.rest.schedule',
                'route_identifier_name' => 'schedule_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Lectures\V1\Rest\Schedule\ScheduleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'lectures.rest.schedule',
                'route_identifier_name' => 'schedule_id',
                'is_collection' => true,
            ],
            'Lectures\\Entity\\Schedule' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'lectures.rest.schedule',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Lectures\\V1\\Rest\\Schedule\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'zf-content-validation' => [
        'Lectures\\V1\\Rest\\Schedule\\Controller' => [
            'input_filter' => 'Lectures\\V1\\Rest\\Schedule\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Lectures\\V1\\Rest\\Schedule\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'ledBy',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'room',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'startTime',
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'endTime',
            ],
            4 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'topic',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'description',
            ],
        ],
    ],
];
