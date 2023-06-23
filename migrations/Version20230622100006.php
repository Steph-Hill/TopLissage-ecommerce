<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622100006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81DB77003');
        $this->addSql('DROP INDEX IDX_D4E6F81DB77003 ON address');
        $this->addSql('ALTER TABLE address DROP professional_id');
        $this->addSql('ALTER TABLE administrator ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_58DF0651F5B7AF75 ON administrator (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD professional_id INT NOT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D4E6F81DB77003 ON address (professional_id)');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651F5B7AF75');
        $this->addSql('DROP INDEX IDX_58DF0651F5B7AF75 ON administrator');
        $this->addSql('ALTER TABLE administrator DROP address_id');
    }
}
