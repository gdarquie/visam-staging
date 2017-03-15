<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315112555 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, secteur_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_497DD6349F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_has_axe (membre_id INT NOT NULL, axe_id INT NOT NULL, INDEX IDX_EA8D416B6A99F74A (membre_id), INDEX IDX_EA8D416B2E30CD41 (axe_id), PRIMARY KEY(membre_id, axe_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_has_tag (membre_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_856EE8C46A99F74A (membre_id), INDEX IDX_856EE8C4BAD26311 (tag_id), PRIMARY KEY(membre_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(500) NOT NULL, UNIQUE INDEX UNIQ_8045251F77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(500) NOT NULL, INDEX IDX_6FF3A701BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6349F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE membre_has_axe ADD CONSTRAINT FK_EA8D416B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (membre_id)');
        $this->addSql('ALTER TABLE membre_has_axe ADD CONSTRAINT FK_EA8D416B2E30CD41 FOREIGN KEY (axe_id) REFERENCES axe (axe_id)');
        $this->addSql('ALTER TABLE membre_has_tag ADD CONSTRAINT FK_856EE8C46A99F74A FOREIGN KEY (membre_id) REFERENCES membre (membre_id)');
        $this->addSql('ALTER TABLE membre_has_tag ADD CONSTRAINT FK_856EE8C4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (tag_id)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A701BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE ED ADD objet_id VARCHAR(255) DEFAULT NULL, ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement ADD objet_id VARCHAR(255) DEFAULT NULL, ADD intervenants INT DEFAULT NULL, ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD objet_id VARCHAR(255) DEFAULT NULL, ADD annee_collecte INT DEFAULT NULL, ADD lmd VARCHAR(255) DEFAULT NULL, ADD ects INT DEFAULT NULL, ADD modalite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE labo ADD effectif_hesam INT DEFAULT NULL, ADD objet_id VARCHAR(255) DEFAULT NULL, ADD annee_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD genre VARCHAR(1) DEFAULT NULL, ADD mail VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE metier ADD souscategorie_id INT DEFAULT NULL, ADD rome VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8CA27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie (id)');
        $this->addSql('CREATE INDEX IDX_51A00D8CA27126E0 ON metier (souscategorie_id)');
        $this->addSql('ALTER TABLE valorisation ADD last_update DATETIME NOT NULL, CHANGE timestamp date_creation DATETIME NOT NULL');
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
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (theme_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, timestamp DATETIME NOT NULL, PRIMARY KEY(theme_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE membre_has_axe');
        $this->addSql('DROP TABLE membre_has_tag');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('ALTER TABLE ED DROP objet_id, DROP annee_collecte');
        $this->addSql('ALTER TABLE etablissement DROP objet_id, DROP intervenants, DROP annee_collecte');
        $this->addSql('ALTER TABLE formation DROP objet_id, DROP annee_collecte, DROP lmd, DROP ects, DROP modalite');
        $this->addSql('ALTER TABLE labo DROP effectif_hesam, DROP objet_id, DROP annee_collecte');
        $this->addSql('ALTER TABLE membre DROP genre, DROP mail');
        $this->addSql('DROP INDEX IDX_51A00D8CA27126E0 ON metier');
        $this->addSql('ALTER TABLE metier DROP souscategorie_id, DROP rome');
        $this->addSql('ALTER TABLE valorisation ADD timestamp DATETIME NOT NULL, DROP date_creation, DROP last_update');
    }
}
