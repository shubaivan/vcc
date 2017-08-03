<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170803103854 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE virtual_card_requests_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE virtual_card_requests (id INT NOT NULL, user_id INT DEFAULT NULL, amount NUMERIC(10, 3) NOT NULL, currency VARCHAR(4) NOT NULL, effective_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, purpose_details JSON NOT NULL, provider_request JSON DEFAULT NULL, provider_response JSON DEFAULT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_on TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A51B03DA76ED395 ON virtual_card_requests (user_id)');
        $this->addSql('ALTER TABLE virtual_card_requests ADD CONSTRAINT FK_3A51B03DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE virtual_cards DROP CONSTRAINT fk_2c29687ea76ed395');
        $this->addSql('DROP INDEX idx_2c29687ea76ed395');
        $this->addSql('ALTER TABLE virtual_cards DROP user_id');
        $this->addSql('ALTER TABLE virtual_cards DROP purpose_details');
        $this->addSql('ALTER TABLE virtual_cards ALTER amount TYPE NUMERIC(10, 3)');
        $this->addSql('ALTER TABLE virtual_cards ALTER amount_on_card TYPE NUMERIC(10, 3)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE virtual_card_requests_id_seq CASCADE');
        $this->addSql('DROP TABLE virtual_card_requests');
        $this->addSql('ALTER TABLE virtual_cards ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE virtual_cards ADD purpose_details JSON NOT NULL');
        $this->addSql('ALTER TABLE virtual_cards ALTER amount TYPE NUMERIC(10, 8)');
        $this->addSql('ALTER TABLE virtual_cards ALTER amount_on_card TYPE NUMERIC(10, 8)');
        $this->addSql('ALTER TABLE virtual_cards ADD CONSTRAINT fk_2c29687ea76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2c29687ea76ed395 ON virtual_cards (user_id)');
    }
}
