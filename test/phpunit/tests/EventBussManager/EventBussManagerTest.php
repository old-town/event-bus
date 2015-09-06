<?php
/**
 * @link https://github.com/old-town/event-buss
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBuss\PhpUnit\Test\EventBussManager;

use OldTown\EventBuss\EventBussManager\EventBussManagerInterface;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use OldTown\EventBuss\EventBussManager\EventBussPluginManager;
use OldTown\EventBuss\EventBussManager\EventBussManagerFacade;
use OldTown\EventBuss\Driver\EventBussDriverInterface;

/**
 * Class EventBussManagerTest
 *
 * @package OldTown\EventBuss\PhpUnit\Test\EventBussManagerFacade
 */
class EventBussManagerTest extends AbstractHttpControllerTestCase
{
    /**
     * Создаем стандартного EventBussManagerFacade
     *
     */
    public function testCreateEventBussDefaultManager()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../_files/application.config.php'
        );
        /** @var EventBussPluginManager $eventBussPluginManager */
        $eventBussPluginManager = $this->getApplicationServiceLocator()->get('eventBussPluginManager');

        static::assertInstanceOf(EventBussPluginManager::class, $eventBussPluginManager);

        $config = [
            'driver' => 'default'
        ];
        /** @var EventBussManagerInterface $eventBussManager */
        $eventBussManager = $eventBussPluginManager->get('default', $config);

        static::assertInstanceOf(EventBussManagerFacade::class, $eventBussManager);

        static::assertInstanceOf(EventBussDriverInterface::class, $eventBussManager->getDriver());
    }
}