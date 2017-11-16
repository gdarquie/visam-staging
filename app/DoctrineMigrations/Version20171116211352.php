<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171116211352 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE discipline_has_laboratoire RENAME INDEX idx_ac8c4dbca5522701 TO IDX_A4BDA9DA5522701');
        $this->addSql('ALTER TABLE discipline_has_laboratoire RENAME INDEX idx_ac8c4dbcb65fa4a TO IDX_A4BDA9D76E2617B');
        $this->addSql('ALTER TABLE discipline_has_ecole_doctorale RENAME INDEX idx_c5488024a5522701 TO IDX_A39BB523A5522701');
        $this->addSql('ALTER TABLE discipline_has_ecole_doctorale RENAME INDEX idx_c5488024bab47356 TO IDX_A39BB523D5F8595C');
        $this->addSql('ALTER TABLE etablissement ADD logo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement_has_laboratoire RENAME INDEX idx_cc521a16ff631228 TO IDX_F5F858C9FF631228');
        $this->addSql('ALTER TABLE etablissement_has_laboratoire RENAME INDEX idx_cc521a16b65fa4a TO IDX_F5F858C976E2617B');
        $this->addSql('ALTER TABLE etablissement_has_ecole_doctorale RENAME INDEX idx_7731f8b3ff631228 TO IDX_E7AFF0CEFF631228');
        $this->addSql('ALTER TABLE etablissement_has_ecole_doctorale RENAME INDEX idx_7731f8b3bab47356 TO IDX_E7AFF0CED5F8595C');
        $this->addSql('ALTER TABLE formation CHANGE url url VARCHAR(500) DEFAULT NULL, CHANGE lien2 lien2 VARCHAR(500) DEFAULT NULL, CHANGE lien3 lien3 VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE participant_has_formation RENAME INDEX idx_464e5dc25200282e TO IDX_E41DAB6C5200282E');
        $this->addSql('ALTER TABLE participant_has_formation RENAME INDEX idx_464e5dc26a99f74a TO IDX_E41DAB6C9D1C3019');
        $this->addSql('ALTER TABLE laboratoire RENAME INDEX idx_9367435c9c347f1c TO IDX_C4AD03C39C347F1C');
        $this->addSql('ALTER TABLE laboratoire_has_theme RENAME INDEX idx_827f9609b65fa4a TO IDX_827F960976E2617B');
        $this->addSql('ALTER TABLE participant_has_laboratoire RENAME INDEX idx_7b597030b65fa4a TO IDX_63D55B7C76E2617B');
        $this->addSql('ALTER TABLE participant_has_laboratoire RENAME INDEX idx_7b5970306a99f74a TO IDX_63D55B7C9D1C3019');
        $this->addSql('ALTER TABLE laboratoire_has_tag RENAME INDEX idx_b73ce04bb65fa4a TO IDX_3FD71D6676E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_tag RENAME INDEX idx_b73ce04bbad26311 TO IDX_3FD71D66BAD26311');
        $this->addSql('ALTER TABLE laboratoire_has_formation RENAME INDEX idx_df3346d9b65fa4a TO IDX_3AFD48DC76E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_formation RENAME INDEX idx_df3346d95200282e TO IDX_3AFD48DC5200282E');
        $this->addSql('ALTER TABLE laboratoire_has_cnu RENAME INDEX idx_da743839b65fa4a TO IDX_529FC51476E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_cnu RENAME INDEX idx_da743839a5522701 TO IDX_529FC514A5522701');
        $this->addSql('ALTER TABLE laboratoire_has_sise RENAME INDEX idx_b30960f6b65fa4a TO IDX_F65ED77E76E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_sise RENAME INDEX idx_b30960f6a5522701 TO IDX_F65ED77EA5522701');
        $this->addSql('ALTER TABLE laboratoire_has_hceres RENAME INDEX idx_d0b16ebeb65fa4a TO IDX_76EE1F8576E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_hceres RENAME INDEX idx_d0b16ebea5522701 TO IDX_76EE1F85A5522701');
        $this->addSql('ALTER TABLE laboratoire_has_equipement RENAME INDEX idx_1cfa71f9b65fa4a TO IDX_6C754B7876E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_equipement RENAME INDEX idx_1cfa71f9806f0f5c TO IDX_6C754B78806F0F5C');
        $this->addSql('ALTER TABLE ecole_doctorale_has_laboratoire RENAME INDEX idx_94fae651b65fa4a TO IDX_6C0DB82C76E2617B');
        $this->addSql('ALTER TABLE ecole_doctorale_has_laboratoire RENAME INDEX idx_94fae651bab47356 TO IDX_6C0DB82CD5F8595C');
        $this->addSql('ALTER TABLE laboratoire_has_axe RENAME INDEX idx_d8df49e4b65fa4a TO IDX_5034B4C976E2617B');
        $this->addSql('ALTER TABLE laboratoire_has_axe RENAME INDEX idx_d8df49e42e30cd41 TO IDX_5034B4C92E30CD41');
        $this->addSql('ALTER TABLE adresse CHANGE type type INT DEFAULT NULL, CHANGE `long` lon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE adresse_has_ufr RENAME INDEX idx_705b91fbc68be09c TO IDX_BA094DFD4DE7DC5C');
        $this->addSql('ALTER TABLE adresse_has_ufr RENAME INDEX idx_705b91fba469cb09 TO IDX_BA094DFDA469CB09');
        $this->addSql('ALTER TABLE adresse_has_laboratoire RENAME INDEX idx_478cff80c68be09c TO IDX_7B1B58CC4DE7DC5C');
        $this->addSql('ALTER TABLE adresse_has_laboratoire RENAME INDEX idx_478cff80b65fa4a TO IDX_7B1B58CC76E2617B');
        $this->addSql('ALTER TABLE adresse_has_formation RENAME INDEX idx_1b027d9fc68be09c TO IDX_7C62D8654DE7DC5C');
        $this->addSql('ALTER TABLE adresse_has_formation RENAME INDEX idx_1b027d9f5200282e TO IDX_7C62D8655200282E');
        $this->addSql('ALTER TABLE adresse_has_etablissement RENAME INDEX idx_db9f843dc68be09c TO IDX_5BDC72294DE7DC5C');
        $this->addSql('ALTER TABLE adresse_has_etablissement RENAME INDEX idx_db9f843dff631228 TO IDX_5BDC7229FF631228');
        $this->addSql('ALTER TABLE adresse_has_ecole_doctorale RENAME INDEX idx_9ac3772cc68be09c TO IDX_AF220EF44DE7DC5C');
        $this->addSql('ALTER TABLE adresse_has_ecole_doctorale RENAME INDEX idx_9ac3772cbab47356 TO IDX_AF220EF4D5F8595C');
        $this->addSql('ALTER TABLE participant_has_axe RENAME INDEX idx_ea8d416b6a99f74a TO IDX_C2A78CDE9D1C3019');
        $this->addSql('ALTER TABLE participant_has_axe RENAME INDEX idx_ea8d416b2e30cd41 TO IDX_C2A78CDE2E30CD41');
        $this->addSql('ALTER TABLE participant_has_ecole_doctorale RENAME INDEX idx_2701bb8c6a99f74a TO IDX_F6039CA19D1C3019');
        $this->addSql('ALTER TABLE participant_has_ecole_doctorale RENAME INDEX idx_2701bb8cbab47356 TO IDX_F6039CA1D5F8595C');
        $this->addSql('ALTER TABLE participant_has_tag RENAME INDEX idx_856ee8c46a99f74a TO IDX_AD4425719D1C3019');
        $this->addSql('ALTER TABLE participant_has_tag RENAME INDEX idx_856ee8c4bad26311 TO IDX_AD442571BAD26311');
        $this->addSql('ALTER TABLE ufr_has_laboratoire RENAME INDEX idx_8b13f098a469cb09 TO IDX_F95EE0FFA469CB09');
        $this->addSql('ALTER TABLE ufr_has_laboratoire RENAME INDEX idx_8b13f098b65fa4a TO IDX_F95EE0FF76E2617B');
        $this->addSql('ALTER TABLE valorisation RENAME INDEX fk_valorisation_adresse1_idx TO fk_valorisation_localisation1_idx');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adresse CHANGE type type INT NOT NULL, CHANGE lon `long` VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE adresse_has_ecole_doctorale RENAME INDEX idx_af220ef44de7dc5c TO IDX_9AC3772CC68BE09C');
        $this->addSql('ALTER TABLE adresse_has_ecole_doctorale RENAME INDEX idx_af220ef4d5f8595c TO IDX_9AC3772CBAB47356');
        $this->addSql('ALTER TABLE adresse_has_etablissement RENAME INDEX idx_5bdc72294de7dc5c TO IDX_DB9F843DC68BE09C');
        $this->addSql('ALTER TABLE adresse_has_etablissement RENAME INDEX idx_5bdc7229ff631228 TO IDX_DB9F843DFF631228');
        $this->addSql('ALTER TABLE adresse_has_formation RENAME INDEX idx_7c62d8654de7dc5c TO IDX_1B027D9FC68BE09C');
        $this->addSql('ALTER TABLE adresse_has_formation RENAME INDEX idx_7c62d8655200282e TO IDX_1B027D9F5200282E');
        $this->addSql('ALTER TABLE adresse_has_laboratoire RENAME INDEX idx_7b1b58cc4de7dc5c TO IDX_478CFF80C68BE09C');
        $this->addSql('ALTER TABLE adresse_has_laboratoire RENAME INDEX idx_7b1b58cc76e2617b TO IDX_478CFF80B65FA4A');
        $this->addSql('ALTER TABLE adresse_has_ufr RENAME INDEX idx_ba094dfd4de7dc5c TO IDX_705B91FBC68BE09C');
        $this->addSql('ALTER TABLE adresse_has_ufr RENAME INDEX idx_ba094dfda469cb09 TO IDX_705B91FBA469CB09');
        $this->addSql('ALTER TABLE discipline_has_ecole_doctorale RENAME INDEX idx_a39bb523a5522701 TO IDX_C5488024A5522701');
        $this->addSql('ALTER TABLE discipline_has_ecole_doctorale RENAME INDEX idx_a39bb523d5f8595c TO IDX_C5488024BAB47356');
        $this->addSql('ALTER TABLE discipline_has_laboratoire RENAME INDEX idx_a4bda9da5522701 TO IDX_AC8C4DBCA5522701');
        $this->addSql('ALTER TABLE discipline_has_laboratoire RENAME INDEX idx_a4bda9d76e2617b TO IDX_AC8C4DBCB65FA4A');
        $this->addSql('ALTER TABLE ecole_doctorale_has_laboratoire RENAME INDEX idx_6c0db82c76e2617b TO IDX_94FAE651B65FA4A');
        $this->addSql('ALTER TABLE ecole_doctorale_has_laboratoire RENAME INDEX idx_6c0db82cd5f8595c TO IDX_94FAE651BAB47356');
        $this->addSql('ALTER TABLE etablissement DROP logo');
        $this->addSql('ALTER TABLE etablissement_has_ecole_doctorale RENAME INDEX idx_e7aff0ceff631228 TO IDX_7731F8B3FF631228');
        $this->addSql('ALTER TABLE etablissement_has_ecole_doctorale RENAME INDEX idx_e7aff0ced5f8595c TO IDX_7731F8B3BAB47356');
        $this->addSql('ALTER TABLE etablissement_has_laboratoire RENAME INDEX idx_f5f858c9ff631228 TO IDX_CC521A16FF631228');
        $this->addSql('ALTER TABLE etablissement_has_laboratoire RENAME INDEX idx_f5f858c976e2617b TO IDX_CC521A16B65FA4A');
        $this->addSql('ALTER TABLE formation CHANGE url url VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE lien2 lien2 VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE lien3 lien3 VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE laboratoire RENAME INDEX idx_c4ad03c39c347f1c TO IDX_9367435C9C347F1C');
        $this->addSql('ALTER TABLE laboratoire_has_axe RENAME INDEX idx_5034b4c976e2617b TO IDX_D8DF49E4B65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_axe RENAME INDEX idx_5034b4c92e30cd41 TO IDX_D8DF49E42E30CD41');
        $this->addSql('ALTER TABLE laboratoire_has_cnu RENAME INDEX idx_529fc51476e2617b TO IDX_DA743839B65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_cnu RENAME INDEX idx_529fc514a5522701 TO IDX_DA743839A5522701');
        $this->addSql('ALTER TABLE laboratoire_has_equipement RENAME INDEX idx_6c754b7876e2617b TO IDX_1CFA71F9B65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_equipement RENAME INDEX idx_6c754b78806f0f5c TO IDX_1CFA71F9806F0F5C');
        $this->addSql('ALTER TABLE laboratoire_has_formation RENAME INDEX idx_3afd48dc76e2617b TO IDX_DF3346D9B65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_formation RENAME INDEX idx_3afd48dc5200282e TO IDX_DF3346D95200282E');
        $this->addSql('ALTER TABLE laboratoire_has_hceres RENAME INDEX idx_76ee1f8576e2617b TO IDX_D0B16EBEB65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_hceres RENAME INDEX idx_76ee1f85a5522701 TO IDX_D0B16EBEA5522701');
        $this->addSql('ALTER TABLE laboratoire_has_sise RENAME INDEX idx_f65ed77e76e2617b TO IDX_B30960F6B65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_sise RENAME INDEX idx_f65ed77ea5522701 TO IDX_B30960F6A5522701');
        $this->addSql('ALTER TABLE laboratoire_has_tag RENAME INDEX idx_3fd71d6676e2617b TO IDX_B73CE04BB65FA4A');
        $this->addSql('ALTER TABLE laboratoire_has_tag RENAME INDEX idx_3fd71d66bad26311 TO IDX_B73CE04BBAD26311');
        $this->addSql('ALTER TABLE laboratoire_has_theme RENAME INDEX idx_827f960976e2617b TO IDX_827F9609B65FA4A');
        $this->addSql('ALTER TABLE participant_has_axe RENAME INDEX idx_c2a78cde9d1c3019 TO IDX_EA8D416B6A99F74A');
        $this->addSql('ALTER TABLE participant_has_axe RENAME INDEX idx_c2a78cde2e30cd41 TO IDX_EA8D416B2E30CD41');
        $this->addSql('ALTER TABLE participant_has_ecole_doctorale RENAME INDEX idx_f6039ca19d1c3019 TO IDX_2701BB8C6A99F74A');
        $this->addSql('ALTER TABLE participant_has_ecole_doctorale RENAME INDEX idx_f6039ca1d5f8595c TO IDX_2701BB8CBAB47356');
        $this->addSql('ALTER TABLE participant_has_formation RENAME INDEX idx_e41dab6c9d1c3019 TO IDX_464E5DC26A99F74A');
        $this->addSql('ALTER TABLE participant_has_formation RENAME INDEX idx_e41dab6c5200282e TO IDX_464E5DC25200282E');
        $this->addSql('ALTER TABLE participant_has_laboratoire RENAME INDEX idx_63d55b7c9d1c3019 TO IDX_7B5970306A99F74A');
        $this->addSql('ALTER TABLE participant_has_laboratoire RENAME INDEX idx_63d55b7c76e2617b TO IDX_7B597030B65FA4A');
        $this->addSql('ALTER TABLE participant_has_tag RENAME INDEX idx_ad4425719d1c3019 TO IDX_856EE8C46A99F74A');
        $this->addSql('ALTER TABLE participant_has_tag RENAME INDEX idx_ad442571bad26311 TO IDX_856EE8C4BAD26311');
        $this->addSql('ALTER TABLE ufr_has_laboratoire RENAME INDEX idx_f95ee0ffa469cb09 TO IDX_8B13F098A469CB09');
        $this->addSql('ALTER TABLE ufr_has_laboratoire RENAME INDEX idx_f95ee0ff76e2617b TO IDX_8B13F098B65FA4A');
        $this->addSql('ALTER TABLE valorisation RENAME INDEX fk_valorisation_localisation1_idx TO fk_valorisation_adresse1_idx');
    }
}
