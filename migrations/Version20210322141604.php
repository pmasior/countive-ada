<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322141604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_budget_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE icon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE method_of_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE settlement_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subcategory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subcategory_budget_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, icon_id_id INT DEFAULT NULL, user_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C13D6AAC6A ON category (icon_id_id)');
        $this->addSql('CREATE INDEX IDX_64C19C19D86650F ON category (user_id_id)');
        $this->addSql('CREATE TABLE category_budget (id INT NOT NULL, category_id_id INT NOT NULL, amount NUMERIC(12, 2) DEFAULT NULL, since TIMESTAMP(0) WITH TIME ZONE NOT NULL, until TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C1A3D009777D11E ON category_budget (category_id_id)');
        $this->addSql('CREATE TABLE currency (id INT NOT NULL, short_name VARCHAR(3) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE icon (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE method_of_payment (id INT NOT NULL, icon_id_id INT DEFAULT NULL, settlement_account_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_424E17D43D6AAC6A ON method_of_payment (icon_id_id)');
        $this->addSql('CREATE INDEX IDX_424E17D4166A391B ON method_of_payment (settlement_account_id)');
        $this->addSql('CREATE TABLE settlement_account (id INT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_687E93CB9D86650F ON settlement_account (user_id_id)');
        $this->addSql('CREATE TABLE subcategory (id INT NOT NULL, icon_id INT DEFAULT NULL, category_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, color VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DDCA44854B9D732 ON subcategory (icon_id)');
        $this->addSql('CREATE INDEX IDX_DDCA4489777D11E ON subcategory (category_id_id)');
        $this->addSql('CREATE TABLE subcategory_budget (id INT NOT NULL, subcategory_id INT NOT NULL, amount NUMERIC(12, 2) DEFAULT NULL, since TIMESTAMP(0) WITH TIME ZONE NOT NULL, until TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1C7329B5DC6FE57 ON subcategory_budget (subcategory_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, category_id_id INT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_389B7839777D11E ON tag (category_id_id)');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, currency_id INT NOT NULL, subcategory_id INT NOT NULL, settlement_account_id INT NOT NULL, method_of_payment_id INT DEFAULT NULL, amount NUMERIC(12, 2) NOT NULL, added_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, note VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D138248176 ON transaction (currency_id)');
        $this->addSql('CREATE INDEX IDX_723705D15DC6FE57 ON transaction (subcategory_id)');
        $this->addSql('CREATE INDEX IDX_723705D1166A391B ON transaction (settlement_account_id)');
        $this->addSql('CREATE INDEX IDX_723705D17826B09F ON transaction (method_of_payment_id)');
        $this->addSql('CREATE TABLE transaction_tag (transaction_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(transaction_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_F8CD024A2FC0CB0F ON transaction_tag (transaction_id)');
        $this->addSql('CREATE INDEX IDX_F8CD024ABAD26311 ON transaction_tag (tag_id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13D6AAC6A FOREIGN KEY (icon_id_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_budget ADD CONSTRAINT FK_7C1A3D009777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE method_of_payment ADD CONSTRAINT FK_424E17D43D6AAC6A FOREIGN KEY (icon_id_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE method_of_payment ADD CONSTRAINT FK_424E17D4166A391B FOREIGN KEY (settlement_account_id) REFERENCES settlement_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE settlement_account ADD CONSTRAINT FK_687E93CB9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44854B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA4489777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subcategory_budget ADD CONSTRAINT FK_C1C7329B5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7839777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D138248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1166A391B FOREIGN KEY (settlement_account_id) REFERENCES settlement_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D17826B09F FOREIGN KEY (method_of_payment_id) REFERENCES method_of_payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction_tag ADD CONSTRAINT FK_F8CD024A2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction_tag ADD CONSTRAINT FK_F8CD024ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_budget DROP CONSTRAINT FK_7C1A3D009777D11E');
        $this->addSql('ALTER TABLE subcategory DROP CONSTRAINT FK_DDCA4489777D11E');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT FK_389B7839777D11E');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D138248176');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C13D6AAC6A');
        $this->addSql('ALTER TABLE method_of_payment DROP CONSTRAINT FK_424E17D43D6AAC6A');
        $this->addSql('ALTER TABLE subcategory DROP CONSTRAINT FK_DDCA44854B9D732');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D17826B09F');
        $this->addSql('ALTER TABLE method_of_payment DROP CONSTRAINT FK_424E17D4166A391B');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1166A391B');
        $this->addSql('ALTER TABLE subcategory_budget DROP CONSTRAINT FK_C1C7329B5DC6FE57');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D15DC6FE57');
        $this->addSql('ALTER TABLE transaction_tag DROP CONSTRAINT FK_F8CD024ABAD26311');
        $this->addSql('ALTER TABLE transaction_tag DROP CONSTRAINT FK_F8CD024A2FC0CB0F');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_budget_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE icon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE method_of_payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE settlement_account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subcategory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subcategory_budget_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transaction_id_seq CASCADE');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_budget');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE icon');
        $this->addSql('DROP TABLE method_of_payment');
        $this->addSql('DROP TABLE settlement_account');
        $this->addSql('DROP TABLE subcategory');
        $this->addSql('DROP TABLE subcategory_budget');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_tag');
    }
}
