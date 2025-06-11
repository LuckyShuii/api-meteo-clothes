<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611111950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE clothe (id SERIAL NOT NULL, clothe_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C32115BAA1915070 ON clothe (clothe_type_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN clothe.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN clothe.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE clothe_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, temperature VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clothe ADD CONSTRAINT FK_C32115BAA1915070 FOREIGN KEY (clothe_type_id) REFERENCES clothe_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clothe DROP CONSTRAINT FK_C32115BAA1915070
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clothe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clothe_type
        SQL);
    }
}
