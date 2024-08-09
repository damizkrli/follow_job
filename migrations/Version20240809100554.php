<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809100554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, contact_id INT NOT NULL, job_board_id INT NOT NULL, job_title VARCHAR(30) NOT NULL, sent DATETIME DEFAULT NULL, response DATETIME DEFAULT NULL, link LONGTEXT NOT NULL, note LONGTEXT DEFAULT NULL, statut VARCHAR(10) NOT NULL, INDEX IDX_A45BDDC1979B1AD6 (company_id), INDEX IDX_A45BDDC1E7A1254A (contact_id), INDEX IDX_A45BDDC180ABF2FE (job_board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, activity VARCHAR(255) NOT NULL, address VARCHAR(75) NOT NULL, postal_code INT NOT NULL, city VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(15) NOT NULL, lastname VARCHAR(15) NOT NULL, email VARCHAR(25) NOT NULL, phone VARCHAR(13) NOT NULL, social VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_board (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, link LONGTEXT NOT NULL, profile TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC180ABF2FE FOREIGN KEY (job_board_id) REFERENCES job_board (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1979B1AD6');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1E7A1254A');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC180ABF2FE');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE job_board');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
