<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426201534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE account (
                        id INT NOT NULL, 
                        account_holder_id INT NOT NULL, 
                        account_manager_id INT NOT NULL, 
                        balance DOUBLE PRECISION NOT NULL, 
                        PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX IDX_7D3656A4FC94BA8B ON account (account_holder_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A484A5C6C7 ON account (account_manager_id)');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4FC94BA8B FOREIGN KEY (account_holder_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A484A5C6C7 FOREIGN KEY (account_manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP TABLE account');
    }
}
