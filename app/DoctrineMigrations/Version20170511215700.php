<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511215700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE labo ADD type_thesaurus INT DEFAULT NULL');
        $this->addSql('ALTER TABLE labo ADD CONSTRAINT FK_9367435C9C347F1C FOREIGN KEY (type_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_9367435C9C347F1C ON labo (type_thesaurus)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE labo DROP FOREIGN KEY FK_9367435C9C347F1C');
        $this->addSql('DROP INDEX IDX_9367435C9C347F1C ON labo');
        $this->addSql('ALTER TABLE labo DROP type_thesaurus');
    }
}
