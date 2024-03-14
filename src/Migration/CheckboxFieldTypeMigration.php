<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\Migration;

use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\StringType;

class CheckboxFieldTypeMigration implements MigrationInterface
{
    private CONST FIELDS = [
        'tl_news' => 'newsalert_sent',
        'tl_news_archive' => 'newsalert_activate',
        'tl_newsalert_recipients' => 'confirmed',
    ];

    public function __construct(
        private Connection $connection
    ) {}

    public function getName(): string
    {
        return 'Newsalert checkbox field migration';
    }

    public function shouldRun(): bool
    {
        foreach (static::FIELDS as $table => $field) {
            if (!$this->connection->createSchemaManager()->tablesExist($table)) {
                return false;
            }

            $schema = $this->connection->createSchemaManager()->introspectSchema();
            if (!($schema->getTable($table)->getColumn($field)->getType() instanceof StringType)) {
                return false;
            }

            $news = $this->connection->executeQuery("SELECT id FROM $table WHERE $field = '0'");
            if ($news->rowCount() > 0) {
                return true;
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $count = 0;
        foreach (static::FIELDS as $table => $field) {
            $result = $this->connection->executeQuery("UPDATE $table SET $field = '' WHERE $field = '0'");
            $count += $result->rowCount();
        }

        return new MigrationResult(true, static::getName().' successful! Updated ' . $count . ' checkbox fields.');
    }
}