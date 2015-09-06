<?php
/**
 * @link    https://github.com/old-town/event-buss
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBuss\PhpUnit\TestData\Messages;

use OldTown\EventBuss\Driver\RabbitMqDriver\MetadataReader\Annotations as EventBuss;


/**
 * Class Foo
 *
 * @package OldTown\EventBuss\TestData\Messages
 *
 * @EventBuss\EventBussMessage(
 *     queue=@EventBuss\Queue(name="test_queue_name_foo"),
 *     exchange=@EventBuss\Exchange(name="test_exchange_name_foo", type="topic"),
 *     bindingKeys={
 *         @EventBuss\BindingKey(
 *             name="*.procedure.*"
 *         ),
 *         @EventBuss\BindingKey(
 *             name="create.procedure.*"
 *         )
 *     }
 * )
 *
 */
class Foo
{

}