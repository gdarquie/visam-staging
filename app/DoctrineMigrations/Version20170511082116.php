<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511082116 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE collecte_has_etablissement (collecte_id INT NOT NULL, etablissement_id INT NOT NULL, INDEX IDX_77DB383E710A9AC6 (collecte_id), INDEX IDX_77DB383EFF631228 (etablissement_id), PRIMARY KEY(collecte_id, etablissement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collecte_has_etablissement ADD CONSTRAINT FK_77DB383E710A9AC6 FOREIGN KEY (collecte_id) REFERENCES collecte (collecte_id)');
        $this->addSql('ALTER TABLE collecte_has_etablissement ADD CONSTRAINT FK_77DB383EFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (etablissement_id)');
        $this->addSql('ALTER TABLE collecte ADD active TINYINT(1) NOT NULL, ADD date_creation DATETIME NOT NULL, ADD last_update DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE collecte_has_etablissement');
        $this->addSql('ALTER TABLE collecte DROP active, DROP date_creation, DROP last_update');
    }
}
