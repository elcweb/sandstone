<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140313225424 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3BC4F1635E237E06 (name), UNIQUE INDEX UNIQ_3BC4F163989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Tagging (id INT AUTO_INCREMENT NOT NULL, tag_id INT DEFAULT NULL, resource_type VARCHAR(50) NOT NULL, resource_id VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6B13E8BFBAD26311 (tag_id), UNIQUE INDEX tagging_idx (tag_id, resource_type, resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acc_accounts (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, type_id INT NOT NULL, name VARCHAR(64) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, root INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, ref VARCHAR(25) DEFAULT NULL, UNIQUE INDEX UNIQ_39C56620989D9B62 (slug), UNIQUE INDEX UNIQ_39C56620146F3EA3 (ref), INDEX IDX_39C56620727ACA70 (parent_id), INDEX IDX_39C56620C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acc_account_types (id INT NOT NULL, name VARCHAR(64) NOT NULL, value VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acc_entries (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, account_id INT NOT NULL, createdAt DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_997177D72FC0CB0F (transaction_id), INDEX IDX_997177D79B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acc_transactions (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, date DATE NOT NULL, comment VARCHAR(80) DEFAULT NULL, ref VARCHAR(25) DEFAULT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_67EAEC4C146F3EA3 (ref), INDEX IDX_67EAEC4C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Tagging ADD CONSTRAINT FK_6B13E8BFBAD26311 FOREIGN KEY (tag_id) REFERENCES Tag (id)");
        $this->addSql("ALTER TABLE acc_accounts ADD CONSTRAINT FK_39C56620727ACA70 FOREIGN KEY (parent_id) REFERENCES acc_accounts (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acc_accounts ADD CONSTRAINT FK_39C56620C54C8C93 FOREIGN KEY (type_id) REFERENCES acc_account_types (id)");
        $this->addSql("ALTER TABLE acc_entries ADD CONSTRAINT FK_997177D72FC0CB0F FOREIGN KEY (transaction_id) REFERENCES acc_transactions (id)");
        $this->addSql("ALTER TABLE acc_entries ADD CONSTRAINT FK_997177D79B6B5FBA FOREIGN KEY (account_id) REFERENCES acc_accounts (id)");
        $this->addSql("ALTER TABLE acc_transactions ADD CONSTRAINT FK_67EAEC4C727ACA70 FOREIGN KEY (parent_id) REFERENCES acc_transactions (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Tagging DROP FOREIGN KEY FK_6B13E8BFBAD26311");
        $this->addSql("ALTER TABLE acc_accounts DROP FOREIGN KEY FK_39C56620727ACA70");
        $this->addSql("ALTER TABLE acc_entries DROP FOREIGN KEY FK_997177D79B6B5FBA");
        $this->addSql("ALTER TABLE acc_accounts DROP FOREIGN KEY FK_39C56620C54C8C93");
        $this->addSql("ALTER TABLE acc_entries DROP FOREIGN KEY FK_997177D72FC0CB0F");
        $this->addSql("ALTER TABLE acc_transactions DROP FOREIGN KEY FK_67EAEC4C727ACA70");
        $this->addSql("DROP TABLE ext_translations");
        $this->addSql("DROP TABLE ext_log_entries");
        $this->addSql("DROP TABLE Tag");
        $this->addSql("DROP TABLE Tagging");
        $this->addSql("DROP TABLE acc_accounts");
        $this->addSql("DROP TABLE acc_account_types");
        $this->addSql("DROP TABLE acc_entries");
        $this->addSql("DROP TABLE acc_transactions");
    }
}
