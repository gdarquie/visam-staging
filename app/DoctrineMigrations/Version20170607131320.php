<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170607131320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_modalite (formation INT NOT NULL, modalite_thesaurus INT NOT NULL, INDEX IDX_2440D8C7404021BF (formation), INDEX IDX_2440D8C77FCC4A02 (modalite_thesaurus), PRIMARY KEY(formation, modalite_thesaurus)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_modalite ADD CONSTRAINT FK_2440D8C7404021BF FOREIGN KEY (formation) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_modalite ADD CONSTRAINT FK_2440D8C77FCC4A02 FOREIGN KEY (modalite_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF7FCC4A02');
        $this->addSql('DROP INDEX IDX_404021BF7FCC4A02 ON formation');
        $this->addSql('ALTER TABLE formation DROP modalite_thesaurus');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formation_has_modalite');
        $this->addSql('ALTER TABLE formation ADD modalite_thesaurus INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF7FCC4A02 FOREIGN KEY (modalite_thesaurus) REFERENCES thesaurus (thesaurus_id)');
        $this->addSql('CREATE INDEX IDX_404021BF7FCC4A02 ON formation (modalite_thesaurus)');
    }
}
