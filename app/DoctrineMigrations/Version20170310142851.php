<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170310142851 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membre_has_axe (membre_id INT NOT NULL, axe_id INT NOT NULL, INDEX IDX_EA8D416B6A99F74A (membre_id), INDEX IDX_EA8D416B2E30CD41 (axe_id), PRIMARY KEY(membre_id, axe_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_has_axe ADD CONSTRAINT FK_EA8D416B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (membre_id)');
        $this->addSql('ALTER TABLE membre_has_axe ADD CONSTRAINT FK_EA8D416B2E30CD41 FOREIGN KEY (axe_id) REFERENCES axe (axe_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membre_has_axe');
    }
}
