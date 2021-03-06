<?php
/**
 * @link https://github.com/old-town/event-bus
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBus\PhpUnit\RabbitMqTestUtils;

/**
 * Interface RabbitMqTestCaseInterface
 * @package OldTown\EventBus\PhpUnit\RabbitMqTestUtils
 */
interface  RabbitMqTestCaseInterface
{
    /**
     * @return RabbitMqTestManager
     */
    public function getRabbitMqTestManager();

    /**
     * @param RabbitMqTestManager $rabbitMqTestManager
     * @return $this
     */
    public function setRabbitMqTestManager(RabbitMqTestManager $rabbitMqTestManager);

    /**
     * Определяет был ли установлен виртуальных хост на котором происходит тестирование
     *
     * @return bool
     */
    public function hasTestVirtualHost();

    /**
     * Определяет был ли установлен менеджер для работы с кроликом
     *
     * @return bool
     */
    public function hasRabbitMqTestManager();

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getTestVirtualHost();

    /**
     * @param string $testVirtualHost
     * @return $this
     */
    public function setTestVirtualHost($testVirtualHost);


    /**
     * Определяет был ли установлен конфиг позволяющий подключиться к тестовому серверу кролика
     *
     * @return bool
     */
    public function hasRabbitMqConnectionForTest();

    /**
     * @return array
     */
    public function getRabbitMqConnectionForTest();
    /**
     * @param array $testRabbitMqConnection
     * @return $this
     */
    public function setRabbitMqConnectionForTest(array $testRabbitMqConnection = []);
}
