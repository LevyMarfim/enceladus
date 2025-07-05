<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250705122510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, author VARCHAR(255) NOT NULL, other_author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) NOT NULL, edition SMALLINT NOT NULL, year SMALLINT NOT NULL, pages SMALLINT NOT NULL, volume SMALLINT DEFAULT NULL, qt_volumes SMALLINT DEFAULT NULL, isbn VARCHAR(64) DEFAULT NULL, original_title VARCHAR(255) DEFAULT NULL, translator VARCHAR(255) DEFAULT NULL, collection VARCHAR(255) DEFAULT NULL, purchase_date DATE DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE book');
    }
}
