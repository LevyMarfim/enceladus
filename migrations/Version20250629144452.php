<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250629144452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE assets_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('CREATE TABLE asset (id SERIAL NOT NULL, company_id INT NOT NULL, ticker VARCHAR(6) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AF5A5C979B1AD6 ON asset (company_id)');
        $this->addSql('CREATE TABLE bill (id SERIAL NOT NULL, company_id INT DEFAULT NULL, bill VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A2119E3979B1AD6 ON bill (company_id)');
        $this->addSql('CREATE TABLE company (id SERIAL NOT NULL, sector_id INT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FBF094FDE95C867 ON company (sector_id)');
        $this->addSql('CREATE TABLE sector (id SERIAL NOT NULL, sector VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, settlement_date DATE NOT NULL, transaction_date DATE NOT NULL, operation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, entry VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, invoice INT DEFAULT NULL, amount INT DEFAULT NULL, unit_price DOUBLE PRECISION DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT fk_eaa81a4c556b180e');
        $this->addSql('DROP TABLE assets');
        $this->addSql('DROP TABLE transactions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE assets_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE assets (id SERIAL NOT NULL, ticker VARCHAR(6) NOT NULL, company VARCHAR(255) NOT NULL, type VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transactions (id SERIAL NOT NULL, ticker_id INT DEFAULT NULL, date DATE NOT NULL, settlement DATE NOT NULL, transaction DATE NOT NULL, operation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, entry VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, invoice VARCHAR(32) DEFAULT NULL, amount SMALLINT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, unit_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_eaa81a4c556b180e ON transactions (ticker_id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT fk_eaa81a4c556b180e FOREIGN KEY (ticker_id) REFERENCES assets (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE asset DROP CONSTRAINT FK_2AF5A5C979B1AD6');
        $this->addSql('ALTER TABLE bill DROP CONSTRAINT FK_7A2119E3979B1AD6');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094FDE95C867');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE transaction');
    }
}
