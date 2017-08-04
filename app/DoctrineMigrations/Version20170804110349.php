<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170804110349 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE virtual_card_requests ADD hotel VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests ADD hotel_room VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests ADD tourists VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests ADD check_in DATE NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests ADD check_out DATE NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests DROP purpose_details');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE virtual_card_requests ADD purpose_details JSON NOT NULL');
        $this->addSql('ALTER TABLE virtual_card_requests DROP hotel');
        $this->addSql('ALTER TABLE virtual_card_requests DROP hotel_room');
        $this->addSql('ALTER TABLE virtual_card_requests DROP tourists');
        $this->addSql('ALTER TABLE virtual_card_requests DROP check_in');
        $this->addSql('ALTER TABLE virtual_card_requests DROP check_out');
    }
}
