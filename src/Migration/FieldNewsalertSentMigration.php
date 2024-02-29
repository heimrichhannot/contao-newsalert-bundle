<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\Migration;

use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\StringType;

class FieldNewsalertSentMigration implements MigrationInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function getName(): string
    {
        return 'Newsalert sent field migration';
    }

    public function shouldRun(): bool
    {
        if (!$this->connection->createSchemaManager()->tablesExist('tl_news')) {
            return false;
        }

        $schema = $this->connection->createSchemaManager()->introspectSchema();
        if (!($schema->getTable('tl_news')->getColumn('newsalert_sent')->getType() instanceof StringType)) {
            return false;
        }

        $news = $this->connection->executeQuery("SELECT id FROM tl_news WHERE newsalert_sent = '0'");
        if ($news->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $result = $this->connection->createQueryBuilder()
            ->update('tl_news')
            ->set('newsalert_sent', ':empty')
            ->where('newsalert_sent = :zero')
            ->setParameter('zero', '0')
            ->setParameter('empty', '')
            ->executeQuery();

        return new MigrationResult(true, 'Updated ' . $result->rowCount() . ' newsalert_sent fields.');
    }
}