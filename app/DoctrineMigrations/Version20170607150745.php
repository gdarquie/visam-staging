<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170607150745 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE ED_has_labo ADD CONSTRAINT FK_94FAE651DB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE localisation_has_ED ADD CONSTRAINT FK_9AC3772CDB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
        $this->addSql('ALTER TABLE membre_has_ED ADD CONSTRAINT FK_2701BB8CDB47F36C FOREIGN KEY (ED_id) REFERENCES ecoledoctorale (ED_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ed_has_labo DROP FOREIGN KEY FK_94FAE651DB47F36C');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY FK_D9DBFCD9DB47F36C');
        $this->addSql('ALTER TABLE localisation_has_ed DROP FOREIGN KEY FK_9AC3772CDB47F36C');
        $this->addSql('ALTER TABLE membre_has_ed DROP FOREIGN KEY FK_2701BB8CDB47F36C');
    }
}
