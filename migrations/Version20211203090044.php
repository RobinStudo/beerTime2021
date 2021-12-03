<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211203090044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Setup entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, icon VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, picture VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, price DOUBLE PRECISION DEFAULT NULL, capacity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, street VARCHAR(120) NOT NULL, zipcode VARCHAR(12) NOT NULL, city VARCHAR(60) NOT NULL, country VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', birthdate DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE rule');
        $this->addSql('DROP TABLE user');
    }
}
