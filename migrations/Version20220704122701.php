<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704122701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bt_bmeeting_room CHANGE invitations_state invitations_state INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_stands ADD location VARCHAR(255) NOT NULL, ADD number_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session_meetings ADD presence INT NOT NULL, ADD realisation INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bt_bmeeting_room CHANGE invitations_state invitations_state INT DEFAULT 0');
        $this->addSql('ALTER TABLE event_stands DROP location, DROP number_id');
        $this->addSql('ALTER TABLE session_meetings DROP presence, DROP realisation');
    }
}
