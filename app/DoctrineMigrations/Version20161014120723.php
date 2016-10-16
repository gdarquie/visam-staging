<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161014120723 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement ADD last_update DATETIME NOT NULL, CHANGE timestamp date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE formation ADD last_update DATETIME NOT NULL, CHANGE timestamp date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE labo ADD last_update DATETIME NOT NULL, CHANGE timestamp date_creation DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement ADD timestamp DATETIME NOT NULL, DROP date_creation, DROP last_update');
        $this->addSql('ALTER TABLE formation ADD timestamp DATETIME NOT NULL, DROP date_creation, DROP last_update');
        $this->addSql('ALTER TABLE labo ADD timestamp DATETIME NOT NULL, DROP date_creation, DROP last_update');
    }
}
