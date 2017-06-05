<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605211404 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation_has_metier DROP FOREIGN KEY FK_852AC92EED16FA20');
        $this->addSql('DROP TABLE formation_has_metier');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (domaine_id)');
        $this->addSql('ALTER TABLE etablissement ADD active TINYINT(1) NOT NULL, CHANGE last_update last_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY fk_etablissement_has_ED_ED1');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY fk_etablissement_has_ED_etablissement1');
        $this->addSql('DROP INDEX idx_7731f8b3ff631228 ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_D9DBFCD9FF631228 ON etablissement_has_ED (etablissement_id)');
        $this->addSql('DROP INDEX idx_7731f8b3db47f36c ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_D9DBFCD9DB47F36C ON etablissement_has_ED (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT fk_etablissement_has_ED_ED1 FOREIGN KEY (ED_id) REFERENCES ED (ED_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT fk_etablissement_has_ED_etablissement1 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE formation ADD niveau_thesaurus INT DEFAULT NULL, ADD lmd_thesaurus INT DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF7A23DAFA FOREIGN KEY (niveau_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF4B295A1C FOREIGN KEY (lmd_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_404021BF7A23DAFA ON formation (niveau_thesaurus)');
        $this->addSql('CREATE INDEX IDX_404021BF4B295A1C ON formation (lmd_thesaurus)');
        $this->addSql('ALTER TABLE fos_user DROP locked, DROP expired, DROP expires_at, DROP credentials_expired, DROP credentials_expire_at, CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(180) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_metier (formation_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_852AC92E5200282E (formation_id), INDEX IDX_852AC92EED16FA20 (metier_id), PRIMARY KEY(formation_id, metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (metier_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, timestamp DATETIME NOT NULL, PRIMARY KEY(metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (theme_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, timestamp DATETIME NOT NULL, PRIMARY KEY(theme_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_metier ADD CONSTRAINT FK_852AC92E5200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_metier ADD CONSTRAINT FK_852AC92EED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (metier_id)');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F4272FC9F');
        $this->addSql('ALTER TABLE etablissement DROP active, CHANGE last_update last_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9FF631228');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('DROP INDEX idx_d9dbfcd9ff631228 ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_7731F8B3FF631228 ON etablissement_has_ED (etablissement_id)');
        $this->addSql('DROP INDEX idx_d9dbfcd9db47f36c ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_7731F8B3DB47F36C ON etablissement_has_ED (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ED (ED_id)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF7A23DAFA');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF4B295A1C');
        $this->addSql('DROP INDEX IDX_404021BF7A23DAFA ON formation');
        $this->addSql('DROP INDEX IDX_404021BF4B295A1C ON formation');
        $this->addSql('ALTER TABLE formation DROP niveau_thesaurus, DROP lmd_thesaurus, CHANGE nom nom VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE fos_user ADD locked TINYINT(1) NOT NULL, ADD expired TINYINT(1) NOT NULL, ADD expires_at DATETIME DEFAULT NULL, ADD credentials_expired TINYINT(1) NOT NULL, ADD credentials_expire_at DATETIME DEFAULT NULL, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE confirmation_token confirmation_token VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
