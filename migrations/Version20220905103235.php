<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905103235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topics ADD text TEXT');
        $this->addSql("UPDATE topics SET text=CONCAT('Текст',' ',id)");
        $this->addSql('ALTER TABLE topics ALTER COLUMN text SET NOT NULL');
        $this->addSql('ALTER TABLE topics ADD create_date TIMESTAMP(0) WITHOUT TIME ZONE ');
        $this->addSql("UPDATE topics SET create_date='2022-09-02 15:52:20'");
        $this->addSql('ALTER TABLE topics ALTER COLUMN create_date SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN topics.create_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE topics DROP text');
        $this->addSql('ALTER TABLE topics DROP create_date');
    }
}
