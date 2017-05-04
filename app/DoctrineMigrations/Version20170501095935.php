<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170501095935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_has_cnu (formation_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_1FFE77705200282E (formation_id), INDEX IDX_1FFE7770A5522701 (discipline_id), PRIMARY KEY(formation_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_has_sise (formation_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_BCCC138D5200282E (formation_id), INDEX IDX_BCCC138DA5522701 (discipline_id), PRIMARY KEY(formation_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_has_hceres (formation_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_D576E1C05200282E (formation_id), INDEX IDX_D576E1C0A5522701 (discipline_id), PRIMARY KEY(formation_id, discipline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_has_cnu ADD CONSTRAINT FK_1FFE77705200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_cnu ADD CONSTRAINT FK_1FFE7770A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
        $this->addSql('ALTER TABLE formation_has_sise ADD CONSTRAINT FK_BCCC138D5200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_sise ADD CONSTRAINT FK_BCCC138DA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
        $this->addSql('ALTER TABLE formation_has_hceres ADD CONSTRAINT FK_D576E1C05200282E FOREIGN KEY (formation_id) REFERENCES formation (formation_id)');
        $this->addSql('ALTER TABLE formation_has_hceres ADD CONSTRAINT FK_D576E1C0A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (discipline_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formation_has_cnu');
        $this->addSql('DROP TABLE formation_has_sise');
        $this->addSql('DROP TABLE formation_has_hceres');
    }
}
