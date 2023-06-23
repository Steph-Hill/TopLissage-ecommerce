<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610163254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professional DROP FOREIGN KEY FK_B3B573AAA1768AFE');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP INDEX IDX_B3B573AAA1768AFE ON professional');
        $this->addSql('ALTER TABLE professional ADD roles JSON NOT NULL, DROP administrator_id_id, DROP name, DROP postal_adress, DROP phone, DROP siret, DROP role, DROP hair_salon, CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3B573AAE7927C74 ON professional (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP INDEX UNIQ_B3B573AAE7927C74 ON professional');
        $this->addSql('ALTER TABLE professional ADD administrator_id_id INT DEFAULT NULL, ADD name VARCHAR(80) NOT NULL, ADD postal_adress VARCHAR(180) NOT NULL, ADD phone VARCHAR(30) NOT NULL, ADD siret VARCHAR(80) NOT NULL, ADD role VARCHAR(50) NOT NULL, ADD hair_salon VARCHAR(255) NOT NULL, DROP roles, CHANGE email email VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE professional ADD CONSTRAINT FK_B3B573AAA1768AFE FOREIGN KEY (administrator_id_id) REFERENCES administrator (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B3B573AAA1768AFE ON professional (administrator_id_id)');
    }
}
