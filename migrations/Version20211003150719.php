<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211003150719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE rent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE rent (id INT NOT NULL, start_station_id INT NOT NULL, end_station_id INT NOT NULL, campervan_id INT NOT NULL, customer_id INT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, deliver_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, get_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2784DCC53721DCB ON rent (start_station_id)');
        $this->addSql('CREATE INDEX IDX_2784DCC2FF5EABB ON rent (end_station_id)');
        $this->addSql('CREATE INDEX IDX_2784DCCB9D53E94 ON rent (campervan_id)');
        $this->addSql('CREATE INDEX IDX_2784DCC9395C3F3 ON rent (customer_id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC53721DCB FOREIGN KEY (start_station_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC2FF5EABB FOREIGN KEY (end_station_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCB9D53E94 FOREIGN KEY (campervan_id) REFERENCES campervan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC9395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE rent_id_seq CASCADE');
        $this->addSql('DROP TABLE rent');
    }
}
