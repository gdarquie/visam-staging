<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170607151833 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ED_has_labo DROP FOREIGN KEY FK_94FAE651DB47F36C');
        $this->addSql('ALTER TABLE discipline_has_ED DROP FOREIGN KEY FK_C5488024DB47F36C');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE localisation_has_ED DROP FOREIGN KEY FK_9AC3772CDB47F36C');
        $this->addSql('ALTER TABLE membre_has_ED DROP FOREIGN KEY FK_2701BB8CDB47F36C');
        $this->addSql('CREATE TABLE ed (code VARCHAR(45) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, objet_id VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, labo_ext TEXT DEFAULT NULL, etab_ext TEXT DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, effectif INT DEFAULT NULL, ED_id INT AUTO_INCREMENT NOT NULL, annee_collecte INT DEFAULT NULL, valide TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, last_update DATETIME NOT NULL, PRIMARY KEY(ED_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE ecoledoctorale');
        $this->addSql('ALTER TABLE discipline_has_ED DROP FOREIGN KEY FK_C5488024DB47F36C');
        $this->addSql('ALTER TABLE discipline_has_ED ADD CONSTRAINT FK_C5488024DB47F36C FOREIGN KEY (ED_id) REFERENCES ed (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ed (ED_id)');
        $this->addSql('ALTER TABLE ED_has_labo DROP FOREIGN KEY FK_94FAE651DB47F36C');
        $this->addSql('ALTER TABLE ED_has_labo ADD CONSTRAINT FK_94FAE651DB47F36C FOREIGN KEY (ED_id) REFERENCES ed (ED_id)');
        $this->addSql('ALTER TABLE localisation_has_ED DROP FOREIGN KEY FK_9AC3772CDB47F36C');
        $this->addSql('ALTER TABLE localisation_has_ED ADD CONSTRAINT FK_9AC3772CDB47F36C FOREIGN KEY (ED_id) REFERENCES ed (ED_id)');
        $this->addSql('ALTER TABLE membre_has_ED DROP FOREIGN KEY FK_2701BB8CDB47F36C');
        $this->addSql('ALTER TABLE membre_has_ED ADD CONSTRAINT FK_2701BB8CDB47F36C FOREIGN KEY (ED_id) REFERENCES ed (ED_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE discipline_has_ed DROP FOREIGN KEY FK_C5488024DB47F36C');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE ed_has_labo DROP FOREIGN KEY FK_94FAE651DB47F36C');
        $this->addSql('ALTER TABLE localisation_has_ed DROP FOREIGN KEY FK_9AC3772CDB47F36C');
        $this->addSql('ALTER TABLE membre_has_ed DROP FOREIGN KEY FK_2701BB8CDB47F36C');
        $this->addSql('CREATE TABLE ecoledoctorale (code VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, nom VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, objet_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, lien VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, labo_ext TEXT DEFAULT NULL COLLATE utf8_unicode_ci, etab_ext TEXT DEFAULT NULL COLLATE utf8_unicode_ci, contact VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, effectif INT DEFAULT NULL, ED_id INT AUTO_INCREMENT NOT NULL, annee_collecte INT DEFAULT NULL, valide TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, last_update DATETIME NOT NULL, PRIMARY KEY(ED_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE ed');
        $this->addSql('ALTER TABLE ed_has_labo DROP FOREIGN KEY FK_94FAE651DB47F36C');
        $this->addSql('ALTER TABLE ed_has_labo ADD CONSTRAINT FK_94FAE651DB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE discipline_has_ed DROP FOREIGN KEY FK_C5488024DB47F36C');
        $this->addSql('ALTER TABLE discipline_has_ed ADD CONSTRAINT FK_C5488024DB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE localisation_has_ed DROP FOREIGN KEY FK_9AC3772CDB47F36C');
        $this->addSql('ALTER TABLE localisation_has_ed ADD CONSTRAINT FK_9AC3772CDB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE membre_has_ed DROP FOREIGN KEY FK_2701BB8CDB47F36C');
        $this->addSql('ALTER TABLE membre_has_ed ADD CONSTRAINT FK_2701BB8CDB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
    }
}
