<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211203090307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change username length';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
