<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211003151750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE rent_equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE rent_equipment (id INT NOT NULL, rent_id INT NOT NULL, equipment_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BD0E5EDE5FD6250 ON rent_equipment (rent_id)');
        $this->addSql('CREATE INDEX IDX_3BD0E5ED517FE9FE ON rent_equipment (equipment_id)');
        $this->addSql('ALTER TABLE rent_equipment ADD CONSTRAINT FK_3BD0E5EDE5FD6250 FOREIGN KEY (rent_id) REFERENCES rent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent_equipment ADD CONSTRAINT FK_3BD0E5ED517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE rent_equipment_id_seq CASCADE');
        $this->addSql('DROP TABLE rent_equipment');
    }
}
