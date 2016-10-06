<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160910160244 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE axe CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE discipline CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE domaine CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ED CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE equipement CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE etablissement CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE formation CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE hesamette CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE labo CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE localisation CHANGE timestamp timestamp DATETIME NOT NULL, CHANGE type type INT NOT NULL');
        $this->addSql('ALTER TABLE membre CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE metier CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ufr CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE valorisation CHANGE timestamp timestamp DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE ED CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE axe CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE discipline CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE domaine CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE equipement CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE etablissement CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE formation CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE hesamette CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE labo CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE localisation CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE type type INT NOT NULL COMMENT \'1 = partenariat, 2 = autres\'');
        $this->addSql('ALTER TABLE membre CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE metier CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE ufr CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE valorisation CHANGE timestamp timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
