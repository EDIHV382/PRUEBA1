<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912001048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E42A37A94');
        $this->addSql('DROP INDEX IDX_F4DF5F3E42A37A94 ON pago');
        $this->addSql('ALTER TABLE pago CHANGE realizado_por_id registrado_por_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3EEC7D893C FOREIGN KEY (registrado_por_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F4DF5F3EEC7D893C ON pago (registrado_por_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3EEC7D893C');
        $this->addSql('DROP INDEX IDX_F4DF5F3EEC7D893C ON pago');
        $this->addSql('ALTER TABLE pago CHANGE registrado_por_id realizado_por_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E42A37A94 FOREIGN KEY (realizado_por_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F4DF5F3E42A37A94 ON pago (realizado_por_id)');
    }
}
