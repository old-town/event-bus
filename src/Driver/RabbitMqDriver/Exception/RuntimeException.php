<?php
/**
 * @link https://github.com/old-town/event-bus
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBus\Driver\RabbitMqDriver\Exception;

use OldTown\EventBus\Driver\Exception\RuntimeException as Exception;

/**
 * Class RuntimeException
 *
 * @package OldTown\EventBus\Driver\RabbitMqDriver\Exception
 */
class RuntimeException extends Exception implements
    ExceptionInterface
{
}
