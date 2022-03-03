<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302123245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC67F0C0D4');
        $this->addSql('DROP INDEX IDX_67F068BC67F0C0D4 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP idclient_id');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677967F0C0D4');
        $this->addSql('DROP INDEX IDX_AF3C677967F0C0D4 ON publication');
        $this->addSql('ALTER TABLE publication DROP idclient_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD idclient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC67F0C0D4 FOREIGN KEY (idclient_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC67F0C0D4 ON commentaire (idclient_id)');
        $this->addSql('ALTER TABLE publication ADD idclient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677967F0C0D4 FOREIGN KEY (idclient_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_AF3C677967F0C0D4 ON publication (idclient_id)');
    }
}
