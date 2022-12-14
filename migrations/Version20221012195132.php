<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012195132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495F3AECE2');
        $this->addSql('DROP INDEX UNIQ_8D93D6495F3AECE2 ON user');
        $this->addSql('ALTER TABLE user CHANGE blood_group_id bloodgroup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64935BAE39B FOREIGN KEY (bloodgroup_id) REFERENCES bloodgroup (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64935BAE39B ON user (bloodgroup_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64935BAE39B');
        $this->addSql('DROP INDEX UNIQ_8D93D64935BAE39B ON user');
        $this->addSql('ALTER TABLE user CHANGE bloodgroup_id blood_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495F3AECE2 FOREIGN KEY (blood_group_id) REFERENCES bloodgroup (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495F3AECE2 ON user (blood_group_id)');
    }
}
