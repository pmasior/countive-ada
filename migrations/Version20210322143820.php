<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322143820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP CONSTRAINT fk_64c19c13d6aac6a');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT fk_64c19c19d86650f');
        $this->addSql('DROP INDEX idx_64c19c19d86650f');
        $this->addSql('DROP INDEX idx_64c19c13d6aac6a');
        $this->addSql('ALTER TABLE category RENAME COLUMN icon_id_id TO icon_id');
        $this->addSql('ALTER TABLE category RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C154B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64C19C154B9D732 ON category (icon_id)');
        $this->addSql('CREATE INDEX IDX_64C19C1A76ED395 ON category (user_id)');
        $this->addSql('ALTER TABLE category_budget DROP CONSTRAINT fk_7c1a3d009777d11e');
        $this->addSql('DROP INDEX idx_7c1a3d009777d11e');
        $this->addSql('ALTER TABLE category_budget RENAME COLUMN category_id_id TO category_id');
        $this->addSql('ALTER TABLE category_budget ADD CONSTRAINT FK_7C1A3D0012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C1A3D0012469DE2 ON category_budget (category_id)');
        $this->addSql('ALTER TABLE method_of_payment DROP CONSTRAINT fk_424e17d43d6aac6a');
        $this->addSql('DROP INDEX idx_424e17d43d6aac6a');
        $this->addSql('ALTER TABLE method_of_payment RENAME COLUMN icon_id_id TO icon_id');
        $this->addSql('ALTER TABLE method_of_payment ADD CONSTRAINT FK_424E17D454B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_424E17D454B9D732 ON method_of_payment (icon_id)');
        $this->addSql('ALTER TABLE subcategory DROP CONSTRAINT fk_ddca4489777d11e');
        $this->addSql('DROP INDEX idx_ddca4489777d11e');
        $this->addSql('ALTER TABLE subcategory RENAME COLUMN category_id_id TO category_id');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DDCA44812469DE2 ON subcategory (category_id)');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT fk_389b7839777d11e');
        $this->addSql('DROP INDEX idx_389b7839777d11e');
        $this->addSql('ALTER TABLE tag RENAME COLUMN category_id_id TO category_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B78312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_389B78312469DE2 ON tag (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C154B9D732');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1A76ED395');
        $this->addSql('DROP INDEX IDX_64C19C154B9D732');
        $this->addSql('DROP INDEX IDX_64C19C1A76ED395');
        $this->addSql('ALTER TABLE category RENAME COLUMN icon_id TO icon_id_id');
        $this->addSql('ALTER TABLE category RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT fk_64c19c13d6aac6a FOREIGN KEY (icon_id_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT fk_64c19c19d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_64c19c19d86650f ON category (user_id_id)');
        $this->addSql('CREATE INDEX idx_64c19c13d6aac6a ON category (icon_id_id)');
        $this->addSql('ALTER TABLE category_budget DROP CONSTRAINT FK_7C1A3D0012469DE2');
        $this->addSql('DROP INDEX IDX_7C1A3D0012469DE2');
        $this->addSql('ALTER TABLE category_budget RENAME COLUMN category_id TO category_id_id');
        $this->addSql('ALTER TABLE category_budget ADD CONSTRAINT fk_7c1a3d009777d11e FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7c1a3d009777d11e ON category_budget (category_id_id)');
        $this->addSql('ALTER TABLE method_of_payment DROP CONSTRAINT FK_424E17D454B9D732');
        $this->addSql('DROP INDEX IDX_424E17D454B9D732');
        $this->addSql('ALTER TABLE method_of_payment RENAME COLUMN icon_id TO icon_id_id');
        $this->addSql('ALTER TABLE method_of_payment ADD CONSTRAINT fk_424e17d43d6aac6a FOREIGN KEY (icon_id_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_424e17d43d6aac6a ON method_of_payment (icon_id_id)');
        $this->addSql('ALTER TABLE subcategory DROP CONSTRAINT FK_DDCA44812469DE2');
        $this->addSql('DROP INDEX IDX_DDCA44812469DE2');
        $this->addSql('ALTER TABLE subcategory RENAME COLUMN category_id TO category_id_id');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT fk_ddca4489777d11e FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ddca4489777d11e ON subcategory (category_id_id)');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT FK_389B78312469DE2');
        $this->addSql('DROP INDEX IDX_389B78312469DE2');
        $this->addSql('ALTER TABLE tag RENAME COLUMN category_id TO category_id_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT fk_389b7839777d11e FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_389b7839777d11e ON tag (category_id_id)');
    }
}
