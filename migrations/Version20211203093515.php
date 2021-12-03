<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211203093515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event_rule (event_id INT NOT NULL, rule_id INT NOT NULL, INDEX IDX_5913E06771F7E88B (event_id), INDEX IDX_5913E067744E0351 (rule_id), PRIMARY KEY(event_id, rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_rule ADD CONSTRAINT FK_5913E06771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_rule ADD CONSTRAINT FK_5913E067744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD category_id INT NOT NULL, ADD place_id INT DEFAULT NULL, ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA77E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7DA6A219 ON event (place_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77E3C61F9 ON event (owner_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event_rule');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7DA6A219');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA77E3C61F9');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7DA6A219 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA77E3C61F9 ON event');
        $this->addSql('ALTER TABLE event DROP category_id, DROP place_id, DROP owner_id');
    }
}
