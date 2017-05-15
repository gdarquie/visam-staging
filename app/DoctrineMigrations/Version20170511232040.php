<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511232040 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_metier3 (formation_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_B181A99D5200282E (formation_id), INDEX IDX_B181A99DED16FA20 (metier_id), PRIMARY KEY(formation_id, metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_metier3 ADD CONSTRAINT FK_B181A99D5200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_metier3 ADD CONSTRAINT FK_B181A99DED16FA20 FOREIGN KEY (metier_id) REFERENCES metier3 (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formation_has_metier3');
    }
}
