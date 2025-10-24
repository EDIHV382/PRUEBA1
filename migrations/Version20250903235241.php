<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903235241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE corte_caja (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, fecha DATE NOT NULL, efectivo_inicial NUMERIC(10, 2) NOT NULL, efectivo_final NUMERIC(10, 2) NOT NULL, terminal_final NUMERIC(10, 2) NOT NULL, transferencia_final NUMERIC(10, 2) NOT NULL, total_efectivo NUMERIC(10, 2) NOT NULL, total_terminal NUMERIC(10, 2) NOT NULL, total_transferencia NUMERIC(10, 2) NOT NULL, total_general NUMERIC(10, 2) NOT NULL, observacion VARCHAR(255) NOT NULL, INDEX IDX_8B89164FDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE corte_caja ADD CONSTRAINT FK_8B89164FDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corte_caja DROP FOREIGN KEY FK_8B89164FDB38439E');
        $this->addSql('DROP TABLE corte_caja');
    }
}
