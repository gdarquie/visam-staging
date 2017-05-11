<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511231206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation ADD typediplome_thesaurus INT DEFAULT NULL, ADD modalite_thesaurus INT DEFAULT NULL, DROP modalite');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF4B0B9D18 FOREIGN KEY (typediplome_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF7FCC4A02 FOREIGN KEY (modalite_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_404021BF4B0B9D18 ON formation (typediplome_thesaurus)');
        $this->addSql('CREATE INDEX IDX_404021BF7FCC4A02 ON formation (modalite_thesaurus)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF4B0B9D18');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF7FCC4A02');
        $this->addSql('DROP INDEX IDX_404021BF4B0B9D18 ON formation');
        $this->addSql('DROP INDEX IDX_404021BF7FCC4A02 ON formation');
        $this->addSql('ALTER TABLE formation ADD modalite VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, DROP typediplome_thesaurus, DROP modalite_thesaurus');
    }
}
