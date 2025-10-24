<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007013418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gasto (id INT AUTO_INCREMENT NOT NULL, registrado_por_id INT NOT NULL, corte_caja_id INT DEFAULT NULL, monto NUMERIC(10, 2) NOT NULL, descripcion LONGTEXT NOT NULL, fecha DATETIME NOT NULL, INDEX IDX_AE43DA14EC7D893C (registrado_por_id), INDEX IDX_AE43DA14957B8115 (corte_caja_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA14EC7D893C FOREIGN KEY (registrado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA14957B8115 FOREIGN KEY (corte_caja_id) REFERENCES corte_caja (id)');
        $this->addSql('ALTER TABLE corte_caja ADD total_gastos NUMERIC(10, 2) NOT NULL, DROP terminal_final, DROP transferencia_final');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gasto DROP FOREIGN KEY FK_AE43DA14EC7D893C');
        $this->addSql('ALTER TABLE gasto DROP FOREIGN KEY FK_AE43DA14957B8115');
        $this->addSql('DROP TABLE gasto');
        $this->addSql('ALTER TABLE corte_caja ADD transferencia_final NUMERIC(10, 2) NOT NULL, CHANGE total_gastos terminal_final NUMERIC(10, 2) NOT NULL');
    }
}
