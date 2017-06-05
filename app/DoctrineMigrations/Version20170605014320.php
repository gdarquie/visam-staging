<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605014320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (domaine_id)');
        $this->addSql('ALTER TABLE etablissement CHANGE last_update last_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD lmd_thesaurus INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF4B295A1C FOREIGN KEY (lmd_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_404021BF4B295A1C ON formation (lmd_thesaurus)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F4272FC9F');
        $this->addSql('ALTER TABLE etablissement CHANGE last_update last_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF4B295A1C');
        $this->addSql('DROP INDEX IDX_404021BF4B295A1C ON formation');
        $this->addSql('ALTER TABLE formation DROP lmd_thesaurus');
    }
}
