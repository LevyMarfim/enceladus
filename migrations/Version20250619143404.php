<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619143404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE transactions (id SERIAL NOT NULL, ticker_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, settlement DATE NOT NULL, transaction DATE NOT NULL, operation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, entry VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, nota_fiscal VARCHAR(32) DEFAULT NULL, amount SMALLINT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4C556B180E ON transactions (ticker_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C556B180E FOREIGN KEY (ticker_id) REFERENCES assets (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C556B180E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transactions
        SQL);
    }
}
