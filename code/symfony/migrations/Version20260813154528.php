<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260813154528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Track the questions already scored for a player';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE player ADD answered_questions LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('UPDATE player SET answered_questions = \'[]\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE player DROP answered_questions');
    }
}
