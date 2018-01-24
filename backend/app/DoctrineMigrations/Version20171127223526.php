<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Replace transport boolean in rescue by evacuation provider
 */
class Version20171127223526 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evacuation_provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rescue ADD evacuation_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rescue ADD CONSTRAINT FK_FA71973B1A95AA13 FOREIGN KEY (evacuation_provider_id) REFERENCES evacuation_provider (id)');
        $this->addSql('CREATE INDEX IDX_FA71973B1A95AA13 ON rescue (evacuation_provider_id)');

        $this->addSql('
            INSERT INTO evacuation_provider(`name`, `type`)
            VALUES ("Sapeur Pompier", "sp"),
                ("Ambulance Privé", "assu"),
                ("Evacuation mais vecteur inconnu", "na")
        ');

        $this->addSql('UPDATE rescue SET evacuation_provider_id = (SELECT id FROM evacuation_provider WHERE type="na") WHERE transport=1');

        $this->addSql('ALTER TABLE rescue DROP transport');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rescue ADD transport TINYINT(1) NOT NULL');

        $this->addSql('UPDATE rescue SET transport=1 WHERE evacuation_provider_id IS NOT NULL');

        $this->addSql('ALTER TABLE rescue DROP FOREIGN KEY FK_FA71973B1A95AA13');
        $this->addSql('DROP TABLE evacuation_provider');
        $this->addSql('DROP INDEX IDX_FA71973B1A95AA13 ON rescue');
        $this->addSql('ALTER TABLE rescue DROP evacuation_provider_id');
    }
}

