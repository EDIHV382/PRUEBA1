<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910201017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago ADD realizado_por_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E42A37A94 FOREIGN KEY (realizado_por_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F4DF5F3E42A37A94 ON pago (realizado_por_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E42A37A94');
        $this->addSql('DROP INDEX IDX_F4DF5F3E42A37A94 ON pago');
        $this->addSql('ALTER TABLE pago DROP realizado_por_id');
    }
}
