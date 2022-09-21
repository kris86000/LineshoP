<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921100458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466812469DE2');
        $this->addSql('DROP INDEX IDX_3AF3466812469DE2 ON categories');
        $this->addSql('ALTER TABLE categories DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466812469DE2 FOREIGN KEY (category_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_3AF3466812469DE2 ON categories (category_id)');
    }
}
