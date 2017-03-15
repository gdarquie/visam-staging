<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315150111 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY FK_6FF3A701BCF5E72D');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6349F7E4405');
        $this->addSql('CREATE TABLE metier1 (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, UNIQUE INDEX UNIQ_678380B177153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier2 (id INT AUTO_INCREMENT NOT NULL, metier1_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_FE8AD10BEDEF1BA1 (metier1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier3 (id INT AUTO_INCREMENT NOT NULL, metier2_id INT DEFAULT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_898DE19DFF5AB44F (metier2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metier2 ADD CONSTRAINT FK_FE8AD10BEDEF1BA1 FOREIGN KEY (metier1_id) REFERENCES metier1 (id)');
        $this->addSql('ALTER TABLE metier3 ADD CONSTRAINT FK_898DE19DFF5AB44F FOREIGN KEY (metier2_id) REFERENCES metier2 (id)');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE souscategorie');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metier2 DROP FOREIGN KEY FK_FE8AD10BEDEF1BA1');
        $this->addSql('ALTER TABLE metier3 DROP FOREIGN KEY FK_898DE19DFF5AB44F');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, secteur_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL COLLATE utf8_unicode_ci, nom VARCHAR(500) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_497DD6349F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL COLLATE utf8_unicode_ci, nom VARCHAR(500) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_8045251F77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, code VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci, nom VARCHAR(500) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_6FF3A701BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6349F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A701BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('DROP TABLE metier1');
        $this->addSql('DROP TABLE metier2');
        $this->addSql('DROP TABLE metier3');
    }
}
