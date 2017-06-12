<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170612013751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_tag (formation_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_72B6AF025200282E (formation_id), INDEX IDX_72B6AF02BAD26311 (tag_id), PRIMARY KEY(formation_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labo_has_tag (labo_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_B73CE04BB65FA4A (labo_id), INDEX IDX_B73CE04BBAD26311 (tag_id), PRIMARY KEY(labo_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_tag ADD CONSTRAINT FK_72B6AF025200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_tag ADD CONSTRAINT FK_72B6AF02BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (tag_id)');
        $this->addSql('ALTER TABLE labo_has_tag ADD CONSTRAINT FK_B73CE04BB65FA4A FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE labo_has_tag ADD CONSTRAINT FK_B73CE04BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (tag_id)');
        $this->addSql('DROP TABLE tag_has_formation');
        $this->addSql('DROP TABLE tag_has_labo');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag_has_formation (tag_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_8F4BC4F7BAD26311 (tag_id), INDEX IDX_8F4BC4F75200282E (formation_id), PRIMARY KEY(tag_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_has_labo (tag_id INT NOT NULL, labo_id INT NOT NULL, INDEX IDX_F80AE3D8B65FA4A (labo_id), INDEX IDX_F80AE3D8BAD26311 (tag_id), PRIMARY KEY(tag_id, labo_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_has_formation ADD CONSTRAINT fk_tag_has_formation_formation1 FOREIGN KEY (formation_id) REFERENCES formation (formation_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tag_has_formation ADD CONSTRAINT fk_tag_has_formation_tag1 FOREIGN KEY (tag_id) REFERENCES tag (tag_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tag_has_labo ADD CONSTRAINT fk_tag_has_labo_labo FOREIGN KEY (labo_id) REFERENCES labo (labo_id)');
        $this->addSql('ALTER TABLE tag_has_labo ADD CONSTRAINT fk_tag_has_labo_tag FOREIGN KEY (tag_id) REFERENCES tag (tag_id)');
        $this->addSql('DROP TABLE formation_has_tag');
        $this->addSql('DROP TABLE labo_has_tag');
    }
}
