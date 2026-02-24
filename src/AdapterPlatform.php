<?php

declare(strict_types=1);

namespace PhpDb\Sqlite;

use Override;
use PDO;
use PhpDb\Adapter\Driver\PdoDriverInterface;
use PhpDb\Adapter\Platform\AbstractPlatform;
use PhpDb\Sql\Strategy\SqlStrategyInterface;

class AdapterPlatform extends AbstractPlatform
{
    /** @var string[] */

    protected array $quoteIdentifier = ['"', '"'];

    /** @var PDO */
    protected $resource;

    /**
     * {@inheritDoc}
     */
    protected string $quoteIdentifierTo = '\'';

    public function __construct(
        protected readonly PdoDriverInterface|PDO|null $driver = null,
        ?SqlStrategyInterface $sqlStrategy = null
    ) {
        $this->sqlStrategy = $sqlStrategy;
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function quoteValue(string $value): string
    {
        $resource = $this->resource;

        if ($resource instanceof PdoDriverInterface) {
            $resource = $resource->getConnection()->getResource();
        }

        if ($resource instanceof PDO) {
            return $resource->quote($value);
        }

        return parent::quoteValue($value);
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function quoteTrustedValue(int|float|string|bool $value): ?string
    {
        $resource = $this->resource;

        if ($resource instanceof PdoDriverInterface) {
            $resource = $resource->getConnection()->getResource();
        }

        if ($resource instanceof PDO) {
            return $resource->quote($value);
        }

        return parent::quoteTrustedValue($value);
    }

    #[Override]
    protected function createDefaultSqlStrategy(): SqlStrategyInterface
    {
        return new Sql\SqliteStrategy();
    }
}
