<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610165617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator ADD name VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE professional ADD administrator_id INT DEFAULT NULL, ADD postal_adress VARCHAR(255) NOT NULL, ADD phone VARCHAR(30) NOT NULL, ADD siret VARCHAR(100) NOT NULL, ADD hair_salon TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE professional ADD CONSTRAINT FK_B3B573AA4B09E92C FOREIGN KEY (administrator_id) REFERENCES administrator (id)');
        $this->addSql('CREATE INDEX IDX_B3B573AA4B09E92C ON professional (administrator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP name');
        $this->addSql('ALTER TABLE professional DROP FOREIGN KEY FK_B3B573AA4B09E92C');
        $this->addSql('DROP INDEX IDX_B3B573AA4B09E92C ON professional');
        $this->addSql('ALTER TABLE professional DROP administrator_id, DROP postal_adress, DROP phone, DROP siret, DROP hair_salon');
    }
}
