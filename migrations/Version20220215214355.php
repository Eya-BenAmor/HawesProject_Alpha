<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215214355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD randonnee_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11C8C97C3C FOREIGN KEY (randonnee_id) REFERENCES randonnee (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11C8C97C3C ON participant (randonnee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11C8C97C3C');
        $this->addSql('DROP INDEX IDX_D79F6B11C8C97C3C ON participant');
        $this->addSql('ALTER TABLE participant DROP randonnee_id, CHANGE tel tel VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE maladie maladie VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE classe classe VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE randonnee CHANGE nom_rando nom_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE destination destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE categorie_rando categorie_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree_rando duree_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
