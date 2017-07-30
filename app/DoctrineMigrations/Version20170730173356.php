<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * first migration. Create table `user` and `virtual_cards`
 */
class Version20170730173356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE virtual_cards_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, is_disabled BOOLEAN NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE virtual_cards (id INT NOT NULL, user_id INT DEFAULT NULL, card_no VARCHAR(16) NOT NULL, card_type VARCHAR(20) NOT NULL, amount NUMERIC(10, 8) NOT NULL, effective_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount_on_card NUMERIC(10, 8) NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_on TIMESTAMP(0) WITH TIME ZONE NOT NULL, purpose_details JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2C29687E925FD56F ON virtual_cards (card_no)');
        $this->addSql('CREATE INDEX IDX_2C29687EA76ED395 ON virtual_cards (user_id)');
        $this->addSql('ALTER TABLE virtual_cards ADD CONSTRAINT FK_2C29687EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE virtual_cards DROP CONSTRAINT FK_2C29687EA76ED395');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE virtual_cards_id_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE virtual_cards');
    }
}
