<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220211735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partic_form (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, sexe VARCHAR(1) NOT NULL, exp VARCHAR(255) NOT NULL, so_domaine VARCHAR(255) NOT NULL, so_ass VARCHAR(255) NOT NULL, INDEX IDX_40EF6E371C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partic_form ADD CONSTRAINT FK_40EF6E371C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE partic_form');
        $this->addSql('ALTER TABLE document CHANGE typedoc typedoc VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE liendoc liendoc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation CHANGE nomeq nomeq VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE domaine domaine VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nomform nomform VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE plan plan VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
