<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514223936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, p_user_id INT NOT NULL, token VARCHAR(255) NOT NULL, time_existence DATETIME NOT NULL, date_create DATETIME NOT NULL, date_last_use DATETIME NOT NULL, user_agent VARCHAR(255) NOT NULL, ip_last_use VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7BA2F5EB5F37A13B (token), INDEX IDX_7BA2F5EBA0AE3AFA (p_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, type_chat_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_659DF2AA32BB1ED0 (type_chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_member (id INT AUTO_INCREMENT NOT NULL, p_user_id INT NOT NULL, chat_id INT NOT NULL, INDEX IDX_1738CD59A0AE3AFA (p_user_id), INDEX IDX_1738CD591A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE confirmation (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, hash VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, time_existence DATETIME NOT NULL, confirmed TINYINT(1) NOT NULL, attempts INT NOT NULL, phone BIGINT NOT NULL, type INT NOT NULL, is_use TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, p_user_id INT NOT NULL, chat_id INT NOT NULL, chat_member_id INT NOT NULL, text VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, INDEX IDX_B6BD307FA0AE3AFA (p_user_id), INDEX IDX_B6BD307F1A9A7125 (chat_id), INDEX IDX_B6BD307F537AC185 (chat_member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_chat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone BIGINT NOT NULL, date_create DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), UNIQUE INDEX UNIQ_8D93D649444F97DD (phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EBA0AE3AFA FOREIGN KEY (p_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA32BB1ED0 FOREIGN KEY (type_chat_id) REFERENCES type_chat (id)');
        $this->addSql('ALTER TABLE chat_member ADD CONSTRAINT FK_1738CD59A0AE3AFA FOREIGN KEY (p_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE chat_member ADD CONSTRAINT FK_1738CD591A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA0AE3AFA FOREIGN KEY (p_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F537AC185 FOREIGN KEY (chat_member_id) REFERENCES chat_member (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_member DROP FOREIGN KEY FK_1738CD591A9A7125');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F537AC185');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA32BB1ED0');
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EBA0AE3AFA');
        $this->addSql('ALTER TABLE chat_member DROP FOREIGN KEY FK_1738CD59A0AE3AFA');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA0AE3AFA');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE chat_member');
        $this->addSql('DROP TABLE confirmation');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE type_chat');
        $this->addSql('DROP TABLE `user`');
    }
}
