<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724170842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1F6203804');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1F6203804');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1F6203804 FOREIGN KEY (statut_id) REFERENCES application (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
