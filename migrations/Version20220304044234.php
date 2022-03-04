<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304044234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference ALTER slug SET NOT NULL');
        $this->addSql('ALTER INDEX conference_slug_unique RENAME TO UNIQ_911533C8989D9B62');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE conference ALTER slug DROP NOT NULL');
        $this->addSql('ALTER INDEX uniq_911533c8989d9b62 RENAME TO conference_slug_unique');
    }
}
