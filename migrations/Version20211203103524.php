<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211203103524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add booking entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE booking (event_id INT NOT NULL, user_id INT NOT NULL, reference BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E00CEDDE71F7E88B (event_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(event_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE booking');
    }
}
