<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117133316 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `on` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE objet ADD category_id INT NOT NULL, DROP note');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C3812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_46CD4C3812469DE2 ON objet (category_id)');
        $this->addSql('ALTER TABLE note_objet ADD objet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note_objet ADD CONSTRAINT FK_23DDEFEFF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
        $this->addSql('CREATE INDEX IDX_23DDEFEFF520CF5A ON note_objet (objet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `on`');
        $this->addSql('ALTER TABLE note_objet DROP FOREIGN KEY FK_23DDEFEFF520CF5A');
        $this->addSql('DROP INDEX IDX_23DDEFEFF520CF5A ON note_objet');
        $this->addSql('ALTER TABLE note_objet DROP objet_id');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C3812469DE2');
        $this->addSql('DROP INDEX IDX_46CD4C3812469DE2 ON objet');
        $this->addSql('ALTER TABLE objet ADD note INT DEFAULT NULL, DROP category_id');
    }
}
