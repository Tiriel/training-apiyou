<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623120443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1D5EF26FB03A8386 ON movie (created_by_id)');
        $this->addSql('ALTER TABLE "user" ADD birthday DATE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "user".birthday IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP birthday');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26FB03A8386');
        $this->addSql('DROP INDEX IDX_1D5EF26FB03A8386');
        $this->addSql('ALTER TABLE movie DROP created_by_id');
    }
}
