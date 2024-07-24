<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724170417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, statut_id INT NOT NULL, company_id INT NOT NULL, contact_id INT NOT NULL, job_board_id INT NOT NULL, UNIQUE INDEX UNIQ_A45BDDC1F6203804 (statut_id), UNIQUE INDEX UNIQ_A45BDDC1979B1AD6 (company_id), UNIQUE INDEX UNIQ_A45BDDC1E7A1254A (contact_id), UNIQUE INDEX UNIQ_A45BDDC180ABF2FE (job_board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1F6203804 FOREIGN KEY (statut_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC180ABF2FE FOREIGN KEY (job_board_id) REFERENCES job_board (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1F6203804');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1979B1AD6');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1E7A1254A');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC180ABF2FE');
        $this->addSql('DROP TABLE application');
    }
}
