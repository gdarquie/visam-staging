<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170510213923 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE axe DROP FOREIGN KEY fk_axe_labo1');
        $this->addSql('ALTER TABLE axe ADD CONSTRAINT FK_6C6A1E2CB65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE axe DROP FOREIGN KEY FK_6C6A1E2CB65FA4A');
        $this->addSql('ALTER TABLE axe ADD CONSTRAINT fk_axe_labo1 FOREIGN KEY (labo_id) REFERENCES labo (labo_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
