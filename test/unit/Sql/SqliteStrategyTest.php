<?php

declare(strict_types=1);

namespace PhpDbTest\Sqlite\Sql;

use PhpDb\Sql\Ddl\AlterTable;
use PhpDb\Sql\Ddl\CreateTable;
use PhpDb\Sql\Select;
use PhpDb\Sqlite\Sql\Ddl\AlterTableDecorator;
use PhpDb\Sqlite\Sql\Ddl\CreateTableDecorator;
use PhpDb\Sqlite\Sql\SelectDecorator;
use PhpDb\Sqlite\Sql\SqliteStrategy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(SqliteStrategy::class)]
final class SqliteStrategyTest extends TestCase
{
    private SqliteStrategy $strategy;

    protected function setUp(): void
    {
        $this->strategy = new SqliteStrategy();
    }

    public function testConstructorSetsTypeDecorators(): void
    {
        self::assertInstanceOf(SqliteStrategy::class, $this->strategy);
    }

    public function testSelectDecoratorIsRegistered(): void
    {
        $reflection         = new ReflectionClass($this->strategy);
        $decoratorsProperty = $reflection->getProperty('decorators');
        $decorators         = $decoratorsProperty->getValue($this->strategy);

        self::assertArrayHasKey(Select::class, $decorators);
        self::assertInstanceOf(SelectDecorator::class, $decorators[Select::class]);
    }

    public function testCreateTableDecoratorIsRegistered(): void
    {
        $reflection         = new ReflectionClass($this->strategy);
        $decoratorsProperty = $reflection->getProperty('decorators');
        $decorators         = $decoratorsProperty->getValue($this->strategy);

        self::assertArrayHasKey(CreateTable::class, $decorators);
        self::assertInstanceOf(CreateTableDecorator::class, $decorators[CreateTable::class]);
    }

    public function testAlterTableDecoratorIsRegistered(): void
    {
        $reflection         = new ReflectionClass($this->strategy);
        $decoratorsProperty = $reflection->getProperty('decorators');
        $decorators         = $decoratorsProperty->getValue($this->strategy);

        self::assertArrayHasKey(AlterTable::class, $decorators);
        self::assertInstanceOf(AlterTableDecorator::class, $decorators[AlterTable::class]);
    }
}
