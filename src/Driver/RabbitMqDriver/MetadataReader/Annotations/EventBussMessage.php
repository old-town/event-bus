<?php
/**
 * @link https://github.com/old-town/event-buss
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations;

/**
 * Class EventBussMessage
 *
 * @package OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations
 *
 * @Annotation
 * @Target("CLASS")
 */
class EventBussMessage
{
    /**
     * @var \OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations\Queue
     */
    public $queue;

    /**
     * @var \OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations\Exchange
     */
    public $exchange;

    /**
     * @var array<\OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations\BindingKey>
     */
    public $bindingKeys = [];
}
