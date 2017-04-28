<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170428124904 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE etablissement_has_statut');
        $this->addSql('ALTER TABLE etablissement ADD statut_thesaurus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592CD25E060E FOREIGN KEY (statut_thesaurus_id) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_20FD592CD25E060E ON etablissement (statut_thesaurus_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etablissement_has_statut (etablissement_id INT NOT NULL, thesaurus_id INT NOT NULL, INDEX IDX_FD45E155FF631228 (etablissement_id), INDEX IDX_FD45E1557D2DB431 (thesaurus_id), PRIMARY KEY(etablissement_id, thesaurus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etablissement_has_statut ADD CONSTRAINT FK_FD45E1557D2DB431 FOREIGN KEY (thesaurus_id) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('ALTER TABLE etablissement_has_statut ADD CONSTRAINT FK_FD45E155FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592CD25E060E');
        $this->addSql('DROP INDEX IDX_20FD592CD25E060E ON etablissement');
        $this->addSql('ALTER TABLE etablissement DROP statut_thesaurus_id');
    }
}
