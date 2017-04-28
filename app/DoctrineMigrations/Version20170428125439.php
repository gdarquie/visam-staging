<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170428125439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement ADD position_thesaurus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C74766E78 FOREIGN KEY (position_thesaurus_id) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_20FD592C74766E78 ON etablissement (position_thesaurus_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C74766E78');
        $this->addSql('DROP INDEX IDX_20FD592C74766E78 ON etablissement');
        $this->addSql('ALTER TABLE etablissement DROP position_thesaurus_id');
    }
}
