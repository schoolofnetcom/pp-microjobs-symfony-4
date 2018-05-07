<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180503072353 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contratacoes (id INT AUTO_INCREMENT NOT NULL, servico_id INT DEFAULT NULL, cliente_id INT DEFAULT NULL, freelancer_id INT DEFAULT NULL, valor NUMERIC(2, 0) NOT NULL, status VARCHAR(1) NOT NULL, data_cadastro DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', data_alteracao DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C99F177182E14982 (servico_id), INDEX IDX_C99F1771DE734E51 (cliente_id), INDEX IDX_C99F17718545BDF5 (freelancer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contratacoes ADD CONSTRAINT FK_C99F177182E14982 FOREIGN KEY (servico_id) REFERENCES servico (id)');
        $this->addSql('ALTER TABLE contratacoes ADD CONSTRAINT FK_C99F1771DE734E51 FOREIGN KEY (cliente_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE contratacoes ADD CONSTRAINT FK_C99F17718545BDF5 FOREIGN KEY (freelancer_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contratacoes');
    }
}
