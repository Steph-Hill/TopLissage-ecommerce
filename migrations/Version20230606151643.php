<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606151643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE hair_salon ADD professional_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hair_salon ADD CONSTRAINT FK_17637AAF1E3D24BD FOREIGN KEY (professional_id_id) REFERENCES professional (id)');
        $this->addSql('CREATE INDEX IDX_17637AAF1E3D24BD ON hair_salon (professional_id_id)');
        $this->addSql('ALTER TABLE `order` ADD professional_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F5299398DB77003 ON `order` (professional_id)');
        $this->addSql('CREATE INDEX IDX_F52993984584665A ON `order` (product_id)');
        $this->addSql('ALTER TABLE order_line ADD order_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE1FCDAEAAA ON order_line (order_id_id)');
        $this->addSql('ALTER TABLE product DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE professional ADD administrator_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professional ADD CONSTRAINT FK_B3B573AAA1768AFE FOREIGN KEY (administrator_id_id) REFERENCES administrator (id)');
        $this->addSql('CREATE INDEX IDX_B3B573AAA1768AFE ON professional (administrator_id_id)');
        $this->addSql('ALTER TABLE shopping_cart ADD professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F6DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('CREATE INDEX IDX_72AAD4F6DB77003 ON shopping_cart (professional_id)');
        $this->addSql('ALTER TABLE shopping_cart_item ADD shopping_cart_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF445F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_E59A1DF445F80CD ON shopping_cart_item (shopping_cart_id)');
        $this->addSql('CREATE INDEX IDX_E59A1DF44584665A ON shopping_cart_item (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F6DB77003');
        $this->addSql('DROP INDEX IDX_72AAD4F6DB77003 ON shopping_cart');
        $this->addSql('ALTER TABLE shopping_cart DROP professional_id');
        $this->addSql('ALTER TABLE category DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE hair_salon DROP FOREIGN KEY FK_17637AAF1E3D24BD');
        $this->addSql('DROP INDEX IDX_17637AAF1E3D24BD ON hair_salon');
        $this->addSql('ALTER TABLE hair_salon DROP professional_id_id');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1FCDAEAAA');
        $this->addSql('DROP INDEX IDX_9CE58EE1FCDAEAAA ON order_line');
        $this->addSql('ALTER TABLE order_line DROP order_id_id');
        $this->addSql('ALTER TABLE professional DROP FOREIGN KEY FK_B3B573AAA1768AFE');
        $this->addSql('DROP INDEX IDX_B3B573AAA1768AFE ON professional');
        $this->addSql('ALTER TABLE professional DROP administrator_id_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DB77003');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('DROP INDEX IDX_F5299398DB77003 ON `order`');
        $this->addSql('DROP INDEX IDX_F52993984584665A ON `order`');
        $this->addSql('ALTER TABLE `order` DROP professional_id, DROP product_id');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF445F80CD');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF44584665A');
        $this->addSql('DROP INDEX IDX_E59A1DF445F80CD ON shopping_cart_item');
        $this->addSql('DROP INDEX IDX_E59A1DF44584665A ON shopping_cart_item');
        $this->addSql('ALTER TABLE shopping_cart_item DROP shopping_cart_id, DROP product_id');
    }
}
