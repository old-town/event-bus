<?php
/**
 * @link https://github.com/old-town/event-buss
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBuss\Driver;

use Zend\ServiceManager\AbstractPluginManager;


/**
 * Class EventBussDriverPluginManager
 *
 * @package OldTown\EventBuss\EventBussManager
 */
class EventBussDriverPluginManager extends AbstractPluginManager
{
    /**
     * @param mixed $plugin
     *
     * @throws Exception\InvalidEventBussDriverException
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof EventBussDriverInterface) {
            $errMsg = sprintf('EventBussManager должен реализовывать %s', EventBussDriverInterface::class);
            throw new Exception\InvalidEventBussDriverException($errMsg);
        }
    }

}