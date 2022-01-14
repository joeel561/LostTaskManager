<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228180806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE private_message (id INT AUTO_INCREMENT NOT NULL, chatroom_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_4744FC9BCAF8A031 (chatroom_id), INDEX IDX_4744FC9BF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9BCAF8A031 FOREIGN KEY (chatroom_id) REFERENCES chatroom (id)');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9BF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE private_message');
    }
}
