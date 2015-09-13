<?php
/**
 * @link https://github.com/old-town/event-bus
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBus\Driver\RabbitMqDriver\Adapter\AmqpPhpExtension\Exception;

use OldTown\EventBus\Driver\RabbitMqDriver\Adapter\Exception\RuntimeException as Exception;

/**
 * Class RuntimeException
 *
 * @package OldTown\EventBus\Driver\RabbitMqDriver\Adapter\AmqpPhpExtension\Exception
 */
class RuntimeException extends Exception implements
    ExceptionInterface
{
}
