<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604122446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP name_user, DROP email_user, DROP password_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD name_user VARCHAR(255) NOT NULL, ADD email_user VARCHAR(255) NOT NULL, ADD password_user VARCHAR(255) NOT NULL, DROP name, DROP email, DROP password, DROP roles');
    }
}
