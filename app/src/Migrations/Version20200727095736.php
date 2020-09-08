<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727095736 extends AbstractMigration
{
    /**
     * GetDescription method.
     * @return string
     */
    public function getDescription(): string
    {

        return '';
    }

    /**
     * Up method.
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F9E962A8DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CFBDFA1412469DE2 (category_id), INDEX IDX_CFBDFA14F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_tag (note_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_737A976326ED0855 (note_id), INDEX IDX_737A9763BAD26311 (tag_id), PRIMARY KEY(note_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_5058659712469DE2 (category_id), INDEX IDX_50586597F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_tag (task_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6C0B4F048DB60186 (task_id), INDEX IDX_6C0B4F04BAD26311 (tag_id), PRIMARY KEY(task_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, userdata_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9AB945D82 (userdata_id), UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE userdata (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE note_tag ADD CONSTRAINT FK_737A976326ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_tag ADD CONSTRAINT FK_737A9763BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AB945D82 FOREIGN KEY (userdata_id) REFERENCES userdata (id)');
    }

    /**
     * Down method.
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1412469DE2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659712469DE2');
        $this->addSql('ALTER TABLE note_tag DROP FOREIGN KEY FK_737A976326ED0855');
        $this->addSql('ALTER TABLE note_tag DROP FOREIGN KEY FK_737A9763BAD26311');
        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F04BAD26311');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8DB60186');
        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F048DB60186');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F675F31B');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597F675F31B');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AB945D82');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE note_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE task_tag');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE userdata');
    }
}
