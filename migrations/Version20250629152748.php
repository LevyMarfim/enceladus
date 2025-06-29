<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250629152748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expense (id SERIAL NOT NULL, expense_type_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D3A8DA6A857C7A9 ON expense (expense_type_id)');
        $this->addSql('CREATE TABLE expense_type (id SERIAL NOT NULL, expense VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A857C7A9 FOREIGN KEY (expense_type_id) REFERENCES expense_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expense DROP CONSTRAINT FK_2D3A8DA6A857C7A9');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE expense_type');
    }
}
