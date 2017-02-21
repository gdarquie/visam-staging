<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170210175421 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, secteur_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_497DD6349F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, UNIQUE INDEX UNIQ_8045251F77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_6FF3A701BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6349F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A701BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE formation ADD lmd VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE metier ADD souscategorie_id INT DEFAULT NULL, ADD rome VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8CA27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie (id)');
        $this->addSql('CREATE INDEX IDX_51A00D8CA27126E0 ON metier (souscategorie_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY FK_6FF3A701BCF5E72D');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6349F7E4405');
        $this->addSql('ALTER TABLE metier DROP FOREIGN KEY FK_51A00D8CA27126E0');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('ALTER TABLE formation DROP lmd');
        $this->addSql('DROP INDEX IDX_51A00D8CA27126E0 ON metier');
        $this->addSql('ALTER TABLE metier DROP souscategorie_id, DROP rome');
    }
}
