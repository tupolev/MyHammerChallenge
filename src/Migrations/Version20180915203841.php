<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180915203841 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_locations (id INT NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_D056A5AB550C01C2 (zipcode), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_users (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_requests (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, location_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(1250) NOT NULL, requested_date_time DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1CC2732A12469DE2 (category_id), INDEX IDX_1CC2732A64D218E (location_id), INDEX IDX_1CC2732AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_categories (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_requests ADD CONSTRAINT FK_1CC2732A12469DE2 FOREIGN KEY (category_id) REFERENCES job_categories (id)');
        $this->addSql('ALTER TABLE job_requests ADD CONSTRAINT FK_1CC2732A64D218E FOREIGN KEY (location_id) REFERENCES job_locations (id)');
        $this->addSql('ALTER TABLE job_requests ADD CONSTRAINT FK_1CC2732AA76ED395 FOREIGN KEY (user_id) REFERENCES job_users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_requests DROP FOREIGN KEY FK_1CC2732A64D218E');
        $this->addSql('ALTER TABLE job_requests DROP FOREIGN KEY FK_1CC2732AA76ED395');
        $this->addSql('ALTER TABLE job_requests DROP FOREIGN KEY FK_1CC2732A12469DE2');
        $this->addSql('DROP TABLE job_locations');
        $this->addSql('DROP TABLE job_users');
        $this->addSql('DROP TABLE job_requests');
        $this->addSql('DROP TABLE job_categories');
    }
}
