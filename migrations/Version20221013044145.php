<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013044145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gender DROP FOREIGN KEY FK_C7470A42A76ED395');
        $this->addSql('DROP INDEX UNIQ_C7470A42A76ED395 ON gender');
        $this->addSql('ALTER TABLE gender DROP user_id');
        $this->addSql('ALTER TABLE user ADD gender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649708A0E0 ON user (gender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gender ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gender ADD CONSTRAINT FK_C7470A42A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7470A42A76ED395 ON gender (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('DROP INDEX UNIQ_8D93D649708A0E0 ON user');
        $this->addSql('ALTER TABLE user DROP gender_id');
    }
}
