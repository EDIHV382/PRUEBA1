<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007020014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gasto DROP FOREIGN KEY FK_AE43DA14EC7D893C');
        $this->addSql('DROP INDEX IDX_AE43DA14EC7D893C ON gasto');
        $this->addSql('ALTER TABLE gasto DROP registrado_por_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gasto ADD registrado_por_id INT NOT NULL');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA14EC7D893C FOREIGN KEY (registrado_por_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AE43DA14EC7D893C ON gasto (registrado_por_id)');
    }
}
