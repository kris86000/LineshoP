<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921101333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168A21214B7 ON articles (categories_id)');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346681EBAF6CC');
        $this->addSql('DROP INDEX IDX_3AF346681EBAF6CC ON categories');
        $this->addSql('ALTER TABLE categories DROP articles_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168A21214B7');
        $this->addSql('DROP INDEX IDX_BFDD3168A21214B7 ON articles');
        $this->addSql('ALTER TABLE articles DROP categories_id');
        $this->addSql('ALTER TABLE categories ADD articles_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346681EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_3AF346681EBAF6CC ON categories (articles_id)');
    }
}
