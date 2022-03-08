<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302233611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, competition_id INT NOT NULL, categorie_cadeau VARCHAR(20) NOT NULL, description_cadeau VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_3D2134607B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, distance INT NOT NULL, date DATE NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cadeau ADD CONSTRAINT FK_3D2134607B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau DROP FOREIGN KEY FK_3D2134607B39D312');
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE competition');
        $this->addSql('ALTER TABLE admin CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE confirm_mdp confirm_mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE participant CHANGE tel tel VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE maladie maladie VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE classe classe VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE randonnee CHANGE nom_rando nom_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE destination destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE categorie_rando categorie_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree_rando duree_rando VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE couleur couleur VARCHAR(7) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE confrim_mdp confrim_mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
