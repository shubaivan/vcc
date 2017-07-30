<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * change `updated_on`
 */
class Version20170730184110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->skipIf(
            !$schema->hasTable('users'),
            'Table users doesn\'t exist'
        );

        $schemaTable = $schema->getTable('users');

        if ($schemaTable->hasColumn('updated_on')) {
            $this->addSql('
                ALTER TABLE users 
                ALTER updated_on TYPE TIMESTAMP(0) WITH TIME ZONE
            ');
            $this->addSql('
                ALTER TABLE users 
                ALTER updated_on DROP DEFAULT
                ');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->skipIf(
            !$schema->hasTable('users'),
            'Table users doesn\'t exist'
        );

        $schemaTable = $schema->getTable('users');

        if ($schemaTable->hasColumn('updated_on')) {
            $this->addSql('CREATE SCHEMA public');
            $this->addSql('
                ALTER TABLE users 
                ALTER updated_on TYPE TIMESTAMP(0) WITH TIME ZONE
            ');
            $this->addSql('
                ALTER TABLE users 
                ALTER updated_on DROP DEFAULT
                ');
        }
    }
}
