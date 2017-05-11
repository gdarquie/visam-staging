<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511222733 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE laboratoire_has_theme (labo_id INT NOT NULL, thesaurus_id INT NOT NULL, INDEX IDX_827F9609B65FA4A (labo_id), INDEX IDX_827F96097D2DB431 (thesaurus_id), PRIMARY KEY(labo_id, thesaurus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE laboratoire_has_theme ADD CONSTRAINT FK_827F9609B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE laboratoire_has_theme ADD CONSTRAINT FK_827F96097D2DB431 FOREIGN KEY (thesaurus_id) REFERENCES thesaurus (thesaurus_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE laboratoire_has_theme');
    }
}
