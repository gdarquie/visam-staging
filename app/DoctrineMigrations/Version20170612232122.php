<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170612232122 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE labo_has_axe (labo_id INT NOT NULL, axe_id INT NOT NULL, INDEX IDX_D8DF49E4B65FA4A (labo_id), INDEX IDX_D8DF49E42E30CD41 (axe_id), PRIMARY KEY(labo_id, axe_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE labo_has_axe ADD CONSTRAINT FK_D8DF49E4B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo_has_axe ADD CONSTRAINT FK_D8DF49E42E30CD41 FOREIGN KEY (axe_id) REFERENCES axe (axe_id)');
        $this->addSql('ALTER TABLE axe DROP FOREIGN KEY FK_6C6A1E2CB65FA4A');
        $this->addSql('DROP INDEX IDX_6C6A1E2CB65FA4A ON axe');
        $this->addSql('ALTER TABLE axe DROP labo_id');
        $this->addSql('ALTER TABLE formation ADD code_interne VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE labo ADD code_interne VARCHAR(100) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE labo_has_axe');
        $this->addSql('ALTER TABLE axe ADD labo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE axe ADD CONSTRAINT FK_6C6A1E2CB65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_6C6A1E2CB65FA4A ON axe (labo_id)');
        $this->addSql('ALTER TABLE formation DROP code_interne');
        $this->addSql('ALTER TABLE labo DROP code_interne');
    }
}
