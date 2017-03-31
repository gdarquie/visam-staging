<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331123920 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parcours_has_metier (parcours_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_8E16EB376E38C0DB (parcours_id), INDEX IDX_8E16EB37ED16FA20 (metier_id), PRIMARY KEY(parcours_id, metier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parcours_has_metier ADD CONSTRAINT FK_8E16EB376E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (parcours_id)');
        $this->addSql('ALTER TABLE parcours_has_metier ADD CONSTRAINT FK_8E16EB37ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier1 (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parcours_has_metier');
    }
}
