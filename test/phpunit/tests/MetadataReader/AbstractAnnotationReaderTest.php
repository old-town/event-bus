<?php
/**
 * @link https://github.com/old-town/event-bus
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\EventBus\PhpUnit\Test\MetadataReader;

use OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations\BindingKey;
use OldTown\EventBus\MetadataReader\AbstractAnnotationReader;
use OldTown\EventBus\PhpUnit\TestData\Messages\BarClassMethodsHydrator;
use OldTown\EventBus\PhpUnit\TestData\Messages\FooExtendAbstractSimpleMessage;
use OldTown\EventBus\PhpUnit\TestData\Messages\TestMessage1;
use OldTown\EventBus\PhpUnit\TestData\MetadataReader\Example;
use PHPUnit_Framework_TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use OldTown\EventBus\PhpUnit\TestData\Messages\Foo;
use OldTown\EventBus\Driver\RabbitMqDriver\MetadataReader\Annotations\EventBusMessage;
use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use OldTown\EventBus\PhpUnit\TestData\TestPaths;

/**
 * Class EventBusMetadataReaderPluginManagerTest
 *
 * @package OldTown\EventBus\PhpUnit\Test\MetadataReader
 */
class AbstractAnnotationReaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Проверяем поведения метода возвращающего список классов которые содержат анотации поддерживаемые данным
     * AnnotationReader, в ситуации когда указали невалидный путь до директории с классами
     *
     * @expectedException \OldTown\EventBus\MetadataReader\Exception\InvalidPathException
     */
    public function testGetAllClassNamesPathNotDir()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class, [
            'paths' => [
                TestPaths::getPathToTestMessageDir() . '/Foo.php'
            ]
        ]);
        $abstractAnnotationReaderMock->getAllClassNames();
    }

    /**
     *  Проверяем поведения метода возвращающего список классов которые содержат анотации поддерживаемые
     * данным AnnotationReader, в ситуации когда указали пути которые следует исключить из поиска
     *
     */
    public function testGetAllClassNamesPathExcludePath()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class, [
            'paths' => [
                TestPaths::getPathToTestMessageDir()
            ]
        ]);
        $abstractAnnotationReaderMock->addExcludePaths([
            TestPaths::getPathToTestDataDir()
        ]);
        $actual = $abstractAnnotationReaderMock->getAllClassNames();
        static::assertEquals([], $actual);
    }


    /**
     *  Проверяем поведения метода возвращающего список классов которые содержат анотации
     *  поддерживаемые данным AnnotationReader
     *
     */
    public function testGetAllClassNames()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class, [
            'paths' => [
                TestPaths::getPathToTestMessageDir()
            ]
        ]);

        $r = new \ReflectionObject($abstractAnnotationReaderMock);

        $property = $r->getProperty('messageAnnotationClasses');
        $property->setAccessible(true);
        $property->setValue($abstractAnnotationReaderMock, [
            EventBusMessage::class
        ]);


        $actual = $abstractAnnotationReaderMock->getAllClassNames();
        $expected = [
            Foo::class,
            TestMessage1::class,
            FooExtendAbstractSimpleMessage::class,
            BarClassMethodsHydrator::class
        ];
        foreach ($expected as $className) {
            $flag = in_array($className, $actual, true);
            static::assertTrue($flag);
        }
        static::assertEquals(count($actual), count($expected));


        //Тест локального кеширования
        $expected = $abstractAnnotationReaderMock->getAllClassNames();
        $actual = $abstractAnnotationReaderMock->getAllClassNames();

        static::assertTrue($expected === $actual);
    }

    /**
     * Тестирование метода isTransient. Провреям ситуацию когда класс не промежуточный. Т.е. содержит анотации
     * которые могут быть прочитанны данным AnnotationReader
     *
     */
    public function testIsTransientFalse()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $r = new \ReflectionObject($abstractAnnotationReaderMock);

        $property = $r->getProperty('messageAnnotationClasses');
        $property->setAccessible(true);
        $property->setValue($abstractAnnotationReaderMock, [
            EventBusMessage::class
        ]);

        $actual = $abstractAnnotationReaderMock->isTransient(Foo::class);
        static::assertFalse($actual);
    }


    /**
     * Тестирование метода isTransient. Провреям ситуацию когда класс промежуточный. Т.е. не содержит анотации
     * которые могут быть прочитанны данным AnnotationReader
     *
     */
    public function testIsTransientTrue()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $actual = $abstractAnnotationReaderMock->isTransient(Foo::class);
        static::assertTrue($actual);
    }


    /**
     *  Проверяем поведения метода getMessageAnnotationClasses - возвращающего список поддерживаемых анотаций
     *
     */
    public function testGetMessageAnnotationClasses()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class, [
            'paths' => [
                TestPaths::getPathToTestMessageDir()
            ]
        ]);

        $r = new \ReflectionObject($abstractAnnotationReaderMock);

        $property = $r->getProperty('messageAnnotationClasses');
        $property->setAccessible(true);
        $property->setValue($abstractAnnotationReaderMock, [
            EventBusMessage::class
        ]);


        $actual = $abstractAnnotationReaderMock->getMessageAnnotationClasses();
        static::assertEquals([EventBusMessage::class => EventBusMessage::class], $actual);

        //Тест локального кеширования
        $expected = $abstractAnnotationReaderMock->getMessageAnnotationClasses();
        $actual = $abstractAnnotationReaderMock->getMessageAnnotationClasses();

        static::assertTrue($expected === $actual);
    }

    /**
     * Тестироание getter/setter свойства fileExtension
     *
     */
    public function testGetterSetterFileExtension()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $expected = 'test_file_extension';
        $abstractAnnotationReaderMock->setFileExtension($expected);
        $actual = $abstractAnnotationReaderMock->getFileExtension();

        static::assertEquals($expected, $actual);
    }


    /**
     * Тест метода GetReader
     *
     */
    public function testGetReader()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        static::assertInstanceOf(DoctrineAnnotationReader::class, $abstractAnnotationReaderMock->getReader());
    }

    /**
     * Тестирование установки/получения путей
     */
    public function testPath()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $expected = [
            'path_1',
            'path_2',
        ];
        $abstractAnnotationReaderMock->addPaths($expected);

        $actual = $abstractAnnotationReaderMock->getPaths();

        static::assertEquals($expected, $actual);
    }


    /**
     * Тестирование установки/получения путей исключенных из поиска
     */
    public function testExcludePaths()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $expected = [
            'path_1',
            'path_2',
        ];
        $abstractAnnotationReaderMock->addExcludePaths($expected);

        $actual = $abstractAnnotationReaderMock->getExcludePaths();

        static::assertEquals($expected, $actual);
    }



    /**
     *  Получение анотаций анотаций для класса
     *
     */
    public function testGetClassAnnotation()
    {
        /** @var AbstractAnnotationReader|PHPUnit_Framework_MockObject_MockObject $abstractAnnotationReaderMock */
        $abstractAnnotationReaderMock = static::getMockForAbstractClass(AbstractAnnotationReader::class);

        $r = new \ReflectionObject($abstractAnnotationReaderMock);

        $property = $r->getProperty('messageAnnotationClasses');
        $property->setAccessible(true);
        $property->setValue($abstractAnnotationReaderMock, [
            EventBusMessage::class
        ]);


        $actualAnnotations = $abstractAnnotationReaderMock->getClassAnnotation(Example::class);

        static::assertEquals(1, count($actualAnnotations));

        /** @var EventBusMessage $actualAnnotation */
        $actualAnnotation = $actualAnnotations[0];

        static::assertEquals($actualAnnotation->exchange->name, 'test_exchange_name_foo');
        static::assertEquals($actualAnnotation->exchange->durable, true);
        static::assertEquals($actualAnnotation->exchange->type, 'topic');

        static::assertEquals($actualAnnotation->queue->name, 'test_queue_name_foo');


        $expectedBindingKeys = [
            'test_binding_key_1',
            'test_binding_key_2'
        ];

        static::assertEquals(count($expectedBindingKeys), count($actualAnnotation->bindingKeys));

        $actualBindingKeys = [];
        /** @var BindingKey[] $currentBindingKeys */
        $currentBindingKeys = $actualAnnotation->bindingKeys;
        foreach ($currentBindingKeys as $key) {
            $actualBindingKeys[$key->name] = $actualBindingKeys;
        }

        foreach ($expectedBindingKeys as $expectedBindingKey) {
            static::assertArrayHasKey($expectedBindingKey, $actualBindingKeys);
        }

        //Тестирование того что работает локальный кеш
        $expectedAnnotations = $abstractAnnotationReaderMock->getClassAnnotation(Example::class);
        $actualAnnotations = $abstractAnnotationReaderMock->getClassAnnotation(Example::class);

        static::assertTrue($expectedAnnotations === $actualAnnotations);
    }
}
