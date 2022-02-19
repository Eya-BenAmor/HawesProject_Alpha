<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219094217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD nombrepage INT NOT NULL, ADD liendoc VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formation ADD nomform VARCHAR(30) DEFAULT NULL, ADD plan VARCHAR(255) DEFAULT NULL, ADD date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP nombrepage, DROP liendoc, CHANGE typedoc typedoc VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation DROP nomform, DROP plan, DROP date, CHANGE nomeq nomeq VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE domaine domaine VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
