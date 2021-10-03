<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211003135738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE station_equipment_relation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE station_equipment_relation (id INT NOT NULL, station_id INT NOT NULL, equipment_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_969FD67821BDB235 ON station_equipment_relation (station_id)');
        $this->addSql('CREATE INDEX IDX_969FD678517FE9FE ON station_equipment_relation (equipment_id)');
        $this->addSql('ALTER TABLE station_equipment_relation ADD CONSTRAINT FK_969FD67821BDB235 FOREIGN KEY (station_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE station_equipment_relation ADD CONSTRAINT FK_969FD678517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE station_equipment_relation_id_seq CASCADE');
        $this->addSql('DROP TABLE station_equipment_relation');
    }
}
