<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912012806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corte_caja CHANGE usuario_id usuario_id INT NOT NULL, CHANGE observacion observacion VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pago ADD corte_caja_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E957B8115 FOREIGN KEY (corte_caja_id) REFERENCES corte_caja (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F4DF5F3E957B8115 ON pago (corte_caja_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corte_caja CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE observacion observacion VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E957B8115');
        $this->addSql('DROP INDEX IDX_F4DF5F3E957B8115 ON pago');
        $this->addSql('ALTER TABLE pago DROP corte_caja_id');
    }
}
