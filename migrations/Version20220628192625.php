<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628192625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE child_game (id INT AUTO_INCREMENT NOT NULL, difficulty_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, nb_player VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, duration INT NOT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, background VARCHAR(255) DEFAULT NULL, button VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_961A927EFCFA9DAE (difficulty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_game ADD CONSTRAINT FK_961A927EFCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE child_game');
    }
}
