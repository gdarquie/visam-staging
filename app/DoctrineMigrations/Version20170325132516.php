<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170325132516 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE thesaurus (thesaurus_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(500) DEFAULT NULL, description MEDIUMTEXT DEFAULT NULL, type VARCHAR(500) DEFAULT NULL, soustype VARCHAR(500) DEFAULT NULL, slug VARCHAR(500) DEFAULT NULL, date_creation DATETIME NOT NULL, last_update DATETIME NOT NULL, PRIMARY KEY(thesaurus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre ADD last_update DATETIME NOT NULL, CHANGE timestamp date_creation DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE thesaurus');
        $this->addSql('ALTER TABLE membre ADD timestamp DATETIME NOT NULL, DROP date_creation, DROP last_update');
    }
}
