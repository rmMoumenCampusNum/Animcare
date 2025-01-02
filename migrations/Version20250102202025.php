<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250102202025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous ADD maitre_id INT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ACF133C25 FOREIGN KEY (maitre_id) REFERENCES maitre (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0ACF133C25 ON rendez_vous (maitre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0ACF133C25');
        $this->addSql('DROP INDEX IDX_65E8AA0ACF133C25 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP maitre_id');
    }
}
