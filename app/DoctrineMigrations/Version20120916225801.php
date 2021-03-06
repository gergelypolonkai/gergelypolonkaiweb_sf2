<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120916225801 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE tagging (id INT AUTO_INCREMENT NOT NULL, tag_id INT DEFAULT NULL, resource_type VARCHAR(50) NOT NULL, resource_id VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A4AED123BAD26311 (tag_id), UNIQUE INDEX tagging_idx (tag_id, resource_type, resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6FBC94265E237E06 (name), UNIQUE INDEX UNIQ_6FBC9426989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE tagging ADD CONSTRAINT FK_A4AED123BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE tagging DROP FOREIGN KEY FK_A4AED123BAD26311");
        $this->addSql("DROP TABLE tagging");
        $this->addSql("DROP TABLE tags");
    }
}
