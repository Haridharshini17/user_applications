<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030174123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE EndUser');
        $this->addSql('ALTER TABLE apitoken ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE apitoken ADD CONSTRAINT FK_23E5A7D3A76ED395 FOREIGN KEY (user_id) REFERENCES end_user (id)');
        $this->addSql('CREATE INDEX IDX_23E5A7D3A76ED395 ON apitoken (user_id)');
        $this->addSql('ALTER TABLE phonenumber DROP user_id, CHANGE users_id users_id INT NOT NULL, CHANGE phone_number phone_number INT NOT NULL');
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
        $this->addSql('CREATE TABLE EndUser (id INT AUTO_INCREMENT NOT NULL, email TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D6495F3AECE2, ADD INDEX blood_group_id (blood_group_id)');
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D649708A0E0, ADD INDEX gender_id (gender_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495F3AECE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT user_ibfk_1 FOREIGN KEY (blood_group_id) REFERENCES bloodgroup (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT user_ibfk_2 FOREIGN KEY (gender_id) REFERENCES gender (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE apitoken DROP FOREIGN KEY FK_23E5A7D3A76ED395');
        $this->addSql('DROP INDEX IDX_23E5A7D3A76ED395 ON apitoken');
        $this->addSql('ALTER TABLE apitoken DROP user_id');
        $this->addSql('ALTER TABLE phonenumber ADD user_id INT NOT NULL, CHANGE users_id users_id INT DEFAULT NULL, CHANGE phone_number phone_number BIGINT NOT NULL');
        $this->addSql('ALTER TABLE phonenumber RENAME INDEX idx_eff286d267b3b43d TO users_id');
    }
}
