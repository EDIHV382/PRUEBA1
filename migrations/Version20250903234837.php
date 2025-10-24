<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903234837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pago (id INT AUTO_INCREMENT NOT NULL, paciente_id INT NOT NULL, monto NUMERIC(10, 2) NOT NULL, metodo_pago VARCHAR(30) NOT NULL, tipo_consulta VARCHAR(30) NOT NULL, fecha_pago DATE NOT NULL, INDEX IDX_F4DF5F3E7310DAD4 (paciente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E7310DAD4');
        $this->addSql('DROP TABLE pago');
    }
}
