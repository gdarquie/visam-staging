<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160817114017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE import_lab (id INT AUTO_INCREMENT NOT NULL, uai VARCHAR(45) DEFAULT NULL, labo INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import_locEtab (id INT AUTO_INCREMENT NOT NULL, loc VARCHAR(255) DEFAULT NULL, etab INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import_tags (id INT AUTO_INCREMENT NOT NULL, uai VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, tag TEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import_ufr (id INT AUTO_INCREMENT NOT NULL, ufr VARCHAR(500) DEFAULT NULL, formation VARCHAR(255) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (theme_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(500) DEFAULT NULL, description LONGTEXT DEFAULT NULL, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(theme_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline_has_labo DROP timestamp');
        $this->addSql('ALTER TABLE discipline_has_formation DROP timesptamp');
        $this->addSql('ALTER TABLE discipline_has_ED DROP timestamp');
        $this->addSql('ALTER TABLE ED_has_labo DROP timestamp');
        $this->addSql('ALTER TABLE localisation_has_labo DROP timestamp');
        $this->addSql('ALTER TABLE tag_has_labo DROP FOREIGN KEY fk_tag_has_labo_labo');
        $this->addSql('ALTER TABLE tag_has_labo DROP timestamp');
        $this->addSql('DROP INDEX fk_tag_has_labo_labo ON tag_has_labo');
        $this->addSql('CREATE INDEX IDX_F80AE3D8B65FA4A ON tag_has_labo (labo_id)');
        $this->addSql('ALTER TABLE tag_has_labo ADD CONSTRAINT fk_tag_has_labo_labo FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE tag_has_formation DROP timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE import_lab');
        $this->addSql('DROP TABLE import_locEtab');
        $this->addSql('DROP TABLE import_tags');
        $this->addSql('DROP TABLE import_ufr');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE ed_has_labo ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE discipline_has_ed ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE discipline_has_formation ADD timesptamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE discipline_has_labo ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE localisation_has_labo ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE tag_has_formation ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE tag_has_labo DROP FOREIGN KEY FK_F80AE3D8B65FA4A');
        $this->addSql('ALTER TABLE tag_has_labo ADD timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('DROP INDEX idx_f80ae3d8b65fa4a ON tag_has_labo');
        $this->addSql('CREATE INDEX fk_tag_has_labo_labo ON tag_has_labo (labo_id)');
        $this->addSql('ALTER TABLE tag_has_labo ADD CONSTRAINT FK_F80AE3D8B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
    }
}
