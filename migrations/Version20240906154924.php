<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906154924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day ADD id_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A0299094513350 FOREIGN KEY (id_card_id) REFERENCES card (id)');
        $this->addSql('CREATE INDEX IDX_E5A0299094513350 ON day (id_card_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A0299094513350');
        $this->addSql('DROP INDEX IDX_E5A0299094513350 ON day');
        $this->addSql('ALTER TABLE day DROP id_card_id');
    }
}
