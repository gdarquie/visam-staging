<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170310170420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ED ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE labo ADD annee_collecte INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ED DROP annee_collecte');
        $this->addSql('ALTER TABLE etablissement DROP annee_collecte');
        $this->addSql('ALTER TABLE formation DROP annee_collecte');
        $this->addSql('ALTER TABLE labo DROP annee_collecte');
    }
}
