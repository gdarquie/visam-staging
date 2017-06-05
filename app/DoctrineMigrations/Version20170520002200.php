<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170520002200 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ED (ED_id)');
        $this->addSql('ALTER TABLE formation CHANGE nom nom VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9FF631228');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE formation CHANGE nom nom VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci');
    }
}
