<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170310141959 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membre_has_tag (membre_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_856EE8C46A99F74A (membre_id), INDEX IDX_856EE8C4BAD26311 (tag_id), PRIMARY KEY(membre_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_has_tag ADD CONSTRAINT FK_856EE8C46A99F74A FOREIGN KEY (membre_id) REFERENCES membre (membre_id)');
        $this->addSql('ALTER TABLE membre_has_tag ADD CONSTRAINT FK_856EE8C4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (tag_id)');
        $this->addSql('ALTER TABLE membre ADD genre VARCHAR(1) DEFAULT NULL, ADD mail VARCHAR(500) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membre_has_tag');
        $this->addSql('ALTER TABLE membre DROP genre, DROP mail');
    }
}
