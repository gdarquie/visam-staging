<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170503093325 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_labo DROP FOREIGN KEY fk_etablissement_has_labo_labo1');
        $this->addSql('ALTER TABLE etablissement_has_labo ADD CONSTRAINT FK_CC521A16B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo ADD check1 TINYINT(1) DEFAULT NULL, ADD check2 TINYINT(1) DEFAULT NULL, ADD check3 TINYINT(1) DEFAULT NULL, ADD check4 TINYINT(1) DEFAULT NULL, ADD check5 TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_labo DROP FOREIGN KEY FK_CC521A16B65FA4A');
        $this->addSql('ALTER TABLE etablissement_has_labo ADD CONSTRAINT fk_etablissement_has_labo_labo1 FOREIGN KEY (labo_id) REFERENCES labo (labo_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE labo DROP check1, DROP check2, DROP check3, DROP check4, DROP check5');
    }
}
