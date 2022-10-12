<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012173946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonenumber ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE phonenumber ADD CONSTRAINT FK_EFF286D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EFF286D2A76ED395 ON phonenumber (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonenumber DROP FOREIGN KEY FK_EFF286D2A76ED395');
        $this->addSql('DROP INDEX IDX_EFF286D2A76ED395 ON phonenumber');
        $this->addSql('ALTER TABLE phonenumber DROP user_id');
    }
}
