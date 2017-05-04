<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170503093814 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation ADD check1 TINYINT(1) NOT NULL, ADD check2 TINYINT(1) NOT NULL, ADD check3 TINYINT(1) NOT NULL, ADD check4 TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE labo CHANGE check1 check1 TINYINT(1) NOT NULL, CHANGE check2 check2 TINYINT(1) NOT NULL, CHANGE check3 check3 TINYINT(1) NOT NULL, CHANGE check4 check4 TINYINT(1) NOT NULL, CHANGE check5 check5 TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation DROP check1, DROP check2, DROP check3, DROP check4');
        $this->addSql('ALTER TABLE labo CHANGE check1 check1 TINYINT(1) DEFAULT NULL, CHANGE check2 check2 TINYINT(1) DEFAULT NULL, CHANGE check3 check3 TINYINT(1) DEFAULT NULL, CHANGE check4 check4 TINYINT(1) DEFAULT NULL, CHANGE check5 check5 TINYINT(1) DEFAULT NULL');
    }
}
