<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921123141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderslines ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE orderslines ADD CONSTRAINT FK_BCF13D267294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_BCF13D267294869C ON orderslines (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderslines DROP FOREIGN KEY FK_BCF13D267294869C');
        $this->addSql('DROP INDEX IDX_BCF13D267294869C ON orderslines');
        $this->addSql('ALTER TABLE orderslines DROP article_id');
    }
}
