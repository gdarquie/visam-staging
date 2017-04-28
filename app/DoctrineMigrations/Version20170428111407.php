<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170428111407 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etablissement_has_ministere (etablissement_id INT NOT NULL, thesaurus_id INT NOT NULL, INDEX IDX_FFD4EC7BFF631228 (etablissement_id), INDEX IDX_FFD4EC7B7D2DB431 (thesaurus_id), PRIMARY KEY(etablissement_id, thesaurus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etablissement_has_ministere ADD CONSTRAINT FK_FFD4EC7BFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE etablissement_has_ministere ADD CONSTRAINT FK_FFD4EC7B7D2DB431 FOREIGN KEY (thesaurus_id) REFERENCES thesaurus (thesaurus_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE etablissement_has_ministere');
    }
}
