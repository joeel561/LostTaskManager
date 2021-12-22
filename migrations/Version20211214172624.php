<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214172624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC3886B1B');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC3886B1B FOREIGN KEY (project_recipient_id) REFERENCES project (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC3886B1B');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC3886B1B FOREIGN KEY (project_recipient_id) REFERENCES user (id)');
    }
}
