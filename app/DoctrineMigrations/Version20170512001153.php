<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512001153 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY fk_etablissement_has_ED_ED1');
        $this->addSql('ALTER TABLE etablissement_has_ED DROP FOREIGN KEY fk_etablissement_has_ED_etablissement1');
        $this->addSql('DROP INDEX idx_7731f8b3ff631228 ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_D9DBFCD9FF631228 ON etablissement_has_ED (etablissement_id)');
        $this->addSql('DROP INDEX idx_7731f8b3db47f36c ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_D9DBFCD9DB47F36C ON etablissement_has_ED (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT fk_etablissement_has_ED_ED1 FOREIGN KEY (ED_id) REFERENCES ED (ED_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT fk_etablissement_has_ED_etablissement1 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
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
        $this->addSql('DROP INDEX idx_d9dbfcd9ff631228 ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_7731F8B3FF631228 ON etablissement_has_ED (etablissement_id)');
        $this->addSql('DROP INDEX idx_d9dbfcd9db47f36c ON etablissement_has_ED');
        $this->addSql('CREATE INDEX IDX_7731F8B3DB47F36C ON etablissement_has_ED (ED_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE etablissement_has_ED ADD CONSTRAINT FK_D9DBFCD9DB47F36C FOREIGN KEY (ED_id) REFERENCES ED (ED_id)');
    }
}
