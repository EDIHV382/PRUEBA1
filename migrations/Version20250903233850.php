<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903233850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cita (id INT AUTO_INCREMENT NOT NULL, paciente_id INT NOT NULL, editado_por_id INT DEFAULT NULL, fecha DATETIME NOT NULL, asistio TINYINT(1) NOT NULL, INDEX IDX_3E379A627310DAD4 (paciente_id), INDEX IDX_3E379A6247055264 (editado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A627310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A6247055264 FOREIGN KEY (editado_por_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A627310DAD4');
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A6247055264');
        $this->addSql('DROP TABLE cita');
    }
}
