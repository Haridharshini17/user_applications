<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015051433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonenumber CHANGE users_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE phonenumber RENAME INDEX users_id TO IDX_EFF286D267B3B43D');
        $this->addSql('ALTER TABLE user DROP INDEX blood_group_id, ADD UNIQUE INDEX UNIQ_8D93D6495F3AECE2 (blood_group_id)');
        $this->addSql('ALTER TABLE user DROP INDEX gender_id, ADD UNIQUE INDEX UNIQ_8D93D649708A0E0 (gender_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY user_ibfk_1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY user_ibfk_2');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495F3AECE2 FOREIGN KEY (blood_group_id) REFERENCES bloodgroup (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D6495F3AECE2, ADD INDEX blood_group_id (blood_group_id)');
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D649708A0E0, ADD INDEX gender_id (gender_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495F3AECE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT user_ibfk_1 FOREIGN KEY (blood_group_id) REFERENCES bloodgroup (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT user_ibfk_2 FOREIGN KEY (gender_id) REFERENCES gender (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE phonenumber CHANGE users_id users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phonenumber RENAME INDEX idx_eff286d267b3b43d TO users_id');
    }
}
