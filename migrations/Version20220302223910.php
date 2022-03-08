<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302223910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1119EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_D79F6B1119EB6921 ON participant');
        $this->addSql('ALTER TABLE participant DROP client_id');
        $this->addSql('ALTER TABLE randonnee CHANGE note note DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participant ADD client_id INT NOT NULL, CHANGE tel tel VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE maladie maladie VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE classe classe VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B1119EB6921 ON participant (client_id)');
        $this->addSql('ALTER TABLE randonnee CHANGE nom_rando nom_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE destination destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE categorie_rando categorie_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree_rando duree_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE note note DOUBLE PRECISION DEFAULT NULL, CHANGE couleur couleur VARCHAR(7) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE confrim_mdp confrim_mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
