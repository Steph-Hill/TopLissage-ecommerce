<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623072309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD administrator_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984B09E92C FOREIGN KEY (administrator_id) REFERENCES administrator (id)');
        $this->addSql('CREATE INDEX IDX_F52993984B09E92C ON `order` (administrator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984B09E92C');
        $this->addSql('DROP INDEX IDX_F52993984B09E92C ON `order`');
        $this->addSql('ALTER TABLE `order` DROP administrator_id');
    }
}
