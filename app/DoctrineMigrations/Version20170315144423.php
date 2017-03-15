<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315144423 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation_has_metier DROP FOREIGN KEY fk_formation_has_metier_metier1');
        $this->addSql('DROP TABLE formation_has_metier');
        $this->addSql('DROP TABLE metier');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_metier (formation_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_852AC92E5200282E (formation_id), INDEX IDX_852AC92EED16FA20 (metier_id), PRIMARY KEY(formation_id, metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (metier_id INT AUTO_INCREMENT NOT NULL, souscategorie_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, timestamp DATETIME NOT NULL, rome VARCHAR(20) NOT NULL COLLATE utf8_general_ci, INDEX IDX_51A00D8CA27126E0 (souscategorie_id), PRIMARY KEY(metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_metier ADD CONSTRAINT fk_formation_has_metier_formation1 FOREIGN KEY (formation_id) REFERENCES formation (formation_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE formation_has_metier ADD CONSTRAINT fk_formation_has_metier_metier1 FOREIGN KEY (metier_id) REFERENCES metier (metier_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8CA27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie (id)');
    }
}
