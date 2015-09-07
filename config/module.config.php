<?php
namespace OldTown\EventBus;

use OldTown\EventBus\Driver\DriverChain;
use OldTown\EventBus\Driver\DriverChainFactory;
use OldTown\EventBus\Driver\EventBusDriverAbstractFactory;
use OldTown\EventBus\Driver\EventBusDriverPluginManager;
use OldTown\EventBus\Driver\EventBusDriverPluginManagerFactory;
use OldTown\EventBus\Driver\RabbitMqDriver;
use OldTown\EventBus\EventBusManager\EventBusManagerFacade;
use OldTown\EventBus\EventBusManager\EventBusManagerAbstractFactory;
use OldTown\EventBus\EventBusManager\EventBusManagerFactory;
use OldTown\EventBus\EventBusManager\EventBusPluginManager;
use OldTown\EventBus\EventBusManager\EventBusPluginManagerFactory;
use OldTown\EventBus\MetadataReader\EventBusMetadataReaderPluginManager;
use OldTown\EventBus\MetadataReader\EventBusMetadataReaderPluginManagerFactory;
use OldTown\EventBus\Options\ModuleOptions;
use OldTown\EventBus\Options\ModuleOptionsFactory;
use OldTown\EventBus\Driver\EventBusPluginDriverAbstractFactory;
use OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\AnnotationReader;
use OldTown\EventBus\Message\EventBusMessagePluginManager;
use OldTown\EventBus\Message\EventBusMessagePluginManagerFactory;


return [
    'service_manager' => [
        'abstract_factories' =>[
            EventBusManagerAbstractFactory::class => EventBusManagerAbstractFactory::class,
            EventBusDriverAbstractFactory::class => EventBusDriverAbstractFactory::class
        ],
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            EventBusPluginManager::class => EventBusPluginManagerFactory::class,
            EventBusDriverPluginManager::class => EventBusDriverPluginManagerFactory::class,
            EventBusMetadataReaderPluginManager::class => EventBusMetadataReaderPluginManagerFactory::class,
            EventBusMessagePluginManager::class => EventBusMessagePluginManagerFactory::class
        ],
        'aliases' => [
            'eventBusPluginManager' => EventBusPluginManager::class,
            'eventBusDriverManager' => EventBusDriverPluginManager::class,
            'eventBusMetadataReaderManager' => EventBusMetadataReaderPluginManager::class,
            'eventBusMessageManager' => EventBusMessagePluginManager::class
        ]
    ],
    'event_bus_manager' => [
        'factories' => [
            EventBusManagerFacade::class => EventBusManagerFactory::class,
        ],
        'aliases' => [
            'default' => EventBusManagerFacade::class
        ]
    ],
    'event_bus_driver' => [
        'factories' => [
            DriverChain::class => DriverChainFactory::class,
        ],
        'abstract_factories' =>[
            EventBusPluginDriverAbstractFactory::class => EventBusPluginDriverAbstractFactory::class
        ],
        'aliases' => [
            'chain' => DriverChain::class,
            'rabbit' => RabbitMqDriver::class
        ]
    ],
    'event_bus_metadata_reader' => [
        'invokables' => [
            AnnotationReader::class => AnnotationReader::class
        ]
    ],
    'event_bus_message' => [

    ],

    'event_bus' => [
        'connection' => [
            'default' => [
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '5672',
                    'vhost'    => '/',
                    'login'    => 'guest',
                    'password' => 'guest'
                ]
            ]
        ],
        'event_bus_manager' => [
            'default' => [
                'driver' => 'default'
            ]
        ],
        'driver' => [
            'default' => [
                'pluginName' => DriverChain::class,
                'drivers' => [
                    'amqp' => [
                        'pluginName' => RabbitMqDriver::class,
                        'connection' => 'default'
                    ]
                ]
            ]
        ]

    ]
];