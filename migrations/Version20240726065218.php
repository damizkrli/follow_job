<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726065218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_company (application_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_A4010C7C3E030ACD (application_id), INDEX IDX_A4010C7C979B1AD6 (company_id), PRIMARY KEY(application_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_company ADD CONSTRAINT FK_A4010C7C3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application_company ADD CONSTRAINT FK_A4010C7C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1979B1AD6');
        $this->addSql('DROP INDEX UNIQ_A45BDDC1979B1AD6 ON application');
        $this->addSql('ALTER TABLE application DROP company_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_company DROP FOREIGN KEY FK_A4010C7C3E030ACD');
        $this->addSql('ALTER TABLE application_company DROP FOREIGN KEY FK_A4010C7C979B1AD6');
        $this->addSql('DROP TABLE application_company');
        $this->addSql('ALTER TABLE application ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1979B1AD6 ON application (company_id)');
    }
}
