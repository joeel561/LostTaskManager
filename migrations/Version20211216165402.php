<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216165402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_message ADD sender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9BF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4744FC9BF624B39D ON private_message (sender_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9BF624B39D');
        $this->addSql('DROP INDEX IDX_4744FC9BF624B39D ON private_message');
        $this->addSql('ALTER TABLE private_message DROP sender_id');
    }
}
