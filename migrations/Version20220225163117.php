<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220225163117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partic_form CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE age age INT NOT NULL, CHANGE sexe sexe VARCHAR(1) NOT NULL, CHANGE exp exp VARCHAR(255) NOT NULL, CHANGE so_domaine so_domaine VARCHAR(255) NOT NULL, CHANGE so_ass so_ass VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document CHANGE typedoc typedoc VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE liendoc liendoc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation CHANGE nomeq nomeq VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE domaine domaine VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nomform nomform VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE plan plan VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE partic_form CHANGE nom nom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE age age VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sexe sexe VARCHAR(1) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE exp exp VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE so_domaine so_domaine VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE so_ass so_ass VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
