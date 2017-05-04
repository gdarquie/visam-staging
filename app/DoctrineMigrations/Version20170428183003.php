<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170428183003 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE labo_has_cnu (labo_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_DA743839B65FA4A (labo_id), INDEX IDX_DA743839A5522701 (discipline_id), PRIMARY KEY(labo_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labo_has_sise (labo_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_B30960F6B65FA4A (labo_id), INDEX IDX_B30960F6A5522701 (discipline_id), PRIMARY KEY(labo_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labo_has_hceres (labo_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_D0B16EBEB65FA4A (labo_id), INDEX IDX_D0B16EBEA5522701 (discipline_id), PRIMARY KEY(labo_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE labo_has_cnu ADD CONSTRAINT FK_DA743839B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo_has_cnu ADD CONSTRAINT FK_DA743839A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
        $this->addSql('ALTER TABLE labo_has_sise ADD CONSTRAINT FK_B30960F6B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo_has_sise ADD CONSTRAINT FK_B30960F6A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
        $this->addSql('ALTER TABLE labo_has_hceres ADD CONSTRAINT FK_D0B16EBEB65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo_has_hceres ADD CONSTRAINT FK_D0B16EBEA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE labo_has_cnu');
        $this->addSql('DROP TABLE labo_has_sise');
        $this->addSql('DROP TABLE labo_has_hceres');
    }
}
