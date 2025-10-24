<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910190227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A6247055264');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A6247055264 FOREIGN KEY (editado_por_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A6247055264');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A6247055264 FOREIGN KEY (editado_por_id) REFERENCES user (id)');
    }
}
