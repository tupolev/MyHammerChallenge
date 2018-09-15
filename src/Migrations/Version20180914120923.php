<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180914120923 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_request (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, location_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(1250) NOT NULL, requested_date_time DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A17838049777D11E (category_id), INDEX IDX_A1783804918DB72 (location_id), INDEX IDX_A17838049D86650F (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, zipcode VARCHAR(5) NOT NULL UNIQUE, city VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A17838049777D11E FOREIGN KEY (category_id) REFERENCES job_category (id)');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A1783804918DB72 FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A17838049D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A17838049D86650F');
        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A17838049777D11E');
        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A1783804918DB72');
        $this->addSql('DROP TABLE job_request');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE job_category');
        $this->addSql('DROP TABLE location');
    }
}
