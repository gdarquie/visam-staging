<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511183327 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, nom_fr VARCHAR(255) NOT NULL, nom_en VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_349F3CAE77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ED ADD valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE formation ADD valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE labo ADD valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE localisation ADD cedex VARCHAR(100) DEFAULT NULL, ADD complement_adresse VARCHAR(255) DEFAULT NULL, ADD code_pays VARCHAR(5) DEFAULT NULL, DROP description');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pays');
        $this->addSql('ALTER TABLE ED DROP valide');
        $this->addSql('ALTER TABLE formation DROP valide');
        $this->addSql('ALTER TABLE labo DROP valide');
        $this->addSql('ALTER TABLE localisation ADD description TEXT DEFAULT NULL COLLATE utf8_general_ci, DROP cedex, DROP complement_adresse, DROP code_pays');
    }
}
