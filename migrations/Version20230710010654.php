<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710010654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator ADD hair_salon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651B50E7EE4 FOREIGN KEY (hair_salon_id) REFERENCES hair_salon (id)');
        $this->addSql('CREATE INDEX IDX_58DF0651B50E7EE4 ON administrator (hair_salon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651B50E7EE4');
        $this->addSql('DROP INDEX IDX_58DF0651B50E7EE4 ON administrator');
        $this->addSql('ALTER TABLE administrator DROP hair_salon_id');
    }
}
