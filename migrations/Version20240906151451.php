<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906151451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, id_day_id INT NOT NULL, content LONGTEXT NOT NULL, position INT DEFAULT NULL, INDEX IDX_FEC530A92FF5F4CB (id_day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, id_day INT NOT NULL, template_day INT NOT NULL, title_day VARCHAR(255) NOT NULL, date_day DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_picture (id INT AUTO_INCREMENT NOT NULL, position INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_picture_picture (day_picture_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_CFEA7D4CC8C53D60 (day_picture_id), INDEX IDX_CFEA7D4CEE45BDBF (picture_id), PRIMARY KEY(day_picture_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_picture_day (day_picture_id INT NOT NULL, day_id INT NOT NULL, INDEX IDX_C30EE566C8C53D60 (day_picture_id), INDEX IDX_C30EE5669C24126 (day_id), PRIMARY KEY(day_picture_id, day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A92FF5F4CB FOREIGN KEY (id_day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE day_picture_picture ADD CONSTRAINT FK_CFEA7D4CC8C53D60 FOREIGN KEY (day_picture_id) REFERENCES day_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_picture_picture ADD CONSTRAINT FK_CFEA7D4CEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_picture_day ADD CONSTRAINT FK_C30EE566C8C53D60 FOREIGN KEY (day_picture_id) REFERENCES day_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_picture_day ADD CONSTRAINT FK_C30EE5669C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A92FF5F4CB');
        $this->addSql('ALTER TABLE day_picture_picture DROP FOREIGN KEY FK_CFEA7D4CC8C53D60');
        $this->addSql('ALTER TABLE day_picture_picture DROP FOREIGN KEY FK_CFEA7D4CEE45BDBF');
        $this->addSql('ALTER TABLE day_picture_day DROP FOREIGN KEY FK_C30EE566C8C53D60');
        $this->addSql('ALTER TABLE day_picture_day DROP FOREIGN KEY FK_C30EE5669C24126');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE day_picture');
        $this->addSql('DROP TABLE day_picture_picture');
        $this->addSql('DROP TABLE day_picture_day');
    }
}
