<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718015237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill_type (id SERIAL NOT NULL, bill VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE bill ADD bill_id INT NOT NULL');
        $this->addSql('ALTER TABLE bill ADD date_reference DATE NOT NULL');
        $this->addSql('ALTER TABLE bill ADD value DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE bill ADD comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bill DROP bill');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E31A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7A2119E31A8C12F5 ON bill (bill_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bill DROP CONSTRAINT FK_7A2119E31A8C12F5');
        $this->addSql('DROP TABLE bill_type');
        $this->addSql('DROP INDEX IDX_7A2119E31A8C12F5');
        $this->addSql('ALTER TABLE bill ADD bill VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE bill DROP bill_id');
        $this->addSql('ALTER TABLE bill DROP date_reference');
        $this->addSql('ALTER TABLE bill DROP value');
        $this->addSql('ALTER TABLE bill DROP comment');
    }
}
