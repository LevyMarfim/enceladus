<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702002628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asset (id SERIAL NOT NULL, company_id INT NOT NULL, ticker VARCHAR(6) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AF5A5C979B1AD6 ON asset (company_id)');
        $this->addSql('CREATE TABLE bill (id SERIAL NOT NULL, company_id INT DEFAULT NULL, bill VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A2119E3979B1AD6 ON bill (company_id)');
        $this->addSql('CREATE TABLE company (id SERIAL NOT NULL, sector_id INT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FBF094FDE95C867 ON company (sector_id)');
        $this->addSql('CREATE TABLE expense (id SERIAL NOT NULL, expense_type_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D3A8DA6A857C7A9 ON expense (expense_type_id)');
        $this->addSql('CREATE TABLE expense_type (id SERIAL NOT NULL, expense VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sector (id SERIAL NOT NULL, sector VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, ticker_id INT DEFAULT NULL, entry VARCHAR(255) NOT NULL, operation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, invoice INT DEFAULT NULL, amount INT DEFAULT NULL, unit_price DOUBLE PRECISION DEFAULT NULL, settlement_date DATE NOT NULL, transaction_date DATE NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1556B180E ON transaction (ticker_id)');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON users (username)');
        $this->addSql('CREATE TABLE vehicle (id SERIAL NOT NULL, vehicle VARCHAR(64) NOT NULL, plate VARCHAR(7) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A857C7A9 FOREIGN KEY (expense_type_id) REFERENCES expense_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1556B180E FOREIGN KEY (ticker_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE asset DROP CONSTRAINT FK_2AF5A5C979B1AD6');
        $this->addSql('ALTER TABLE bill DROP CONSTRAINT FK_7A2119E3979B1AD6');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094FDE95C867');
        $this->addSql('ALTER TABLE expense DROP CONSTRAINT FK_2D3A8DA6A857C7A9');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1556B180E');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE expense_type');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
