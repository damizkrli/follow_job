<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613171058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_application_status');
        $this->addSql('ALTER TABLE application CHANGE status_id status_id INT NOT NULL, CHANGE city city VARCHAR(70) DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC16BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE application RENAME INDEX fk_application_status TO IDX_A45BDDC16BF700BD');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(64) DEFAULT NULL, ADD reset_token_expires_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC16BF700BD');
        $this->addSql('ALTER TABLE application CHANGE status_id status_id INT DEFAULT NULL, CHANGE city city VARCHAR(70) NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_application_status FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE application RENAME INDEX idx_a45bddc16bf700bd TO FK_application_status');
        $this->addSql('ALTER TABLE user DROP reset_token, DROP reset_token_expires_at');
    }
}
