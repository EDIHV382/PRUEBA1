<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251003014431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, paciente_id INT NOT NULL, fecha_consulta DATETIME NOT NULL, motivo LONGTEXT NOT NULL, diagnostico LONGTEXT NOT NULL, tratamiento LONGTEXT NOT NULL, observacion LONGTEXT DEFAULT NULL, INDEX IDX_A6FE3FDE7310DAD4 (paciente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE7310DAD4');
        $this->addSql('DROP TABLE consulta');
    }
}
