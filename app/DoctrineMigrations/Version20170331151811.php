<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331151811 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_parcours (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, rang INT NOT NULL, date_creation DATETIME NOT NULL, last_update DATETIME NOT NULL, INDEX IDX_5E2389125200282E (formation_id), INDEX IDX_5E2389126E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_parcours ADD CONSTRAINT FK_5E2389125200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_parcours ADD CONSTRAINT FK_5E2389126E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (parcours_id)');
        $this->addSql('ALTER TABLE parcours ADD annee_collecte INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formation_parcours');
        $this->addSql('ALTER TABLE parcours DROP annee_collecte');
    }
}
