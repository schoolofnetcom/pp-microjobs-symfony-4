<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180517160327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dados_pessoais (id INT AUTO_INCREMENT NOT NULL, foto VARCHAR(255) DEFAULT NULL, curriculo LONGTEXT DEFAULT NULL, cidade VARCHAR(100) DEFAULT NULL, estado VARCHAR(2) DEFAULT NULL, data_nascimento DATE DEFAULT NULL, cpf VARCHAR(11) DEFAULT NULL, telefone_ddd VARCHAR(2) DEFAULT NULL, telefone_numero VARCHAR(9) DEFAULT NULL, logradouro VARCHAR(150) DEFAULT NULL, endereco_numero VARCHAR(10) DEFAULT NULL, bairro VARCHAR(100) DEFAULT NULL, cod_moip VARCHAR(255) DEFAULT NULL, data_cadastro DATETIME DEFAULT NULL, data_alteracao DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuario ADD dados_pessoais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05DED124139 FOREIGN KEY (dados_pessoais_id) REFERENCES dados_pessoais (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DED124139 ON usuario (dados_pessoais_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05DED124139');
        $this->addSql('DROP TABLE dados_pessoais');
        $this->addSql('DROP INDEX UNIQ_2265B05DED124139 ON usuario');
        $this->addSql('ALTER TABLE usuario DROP dados_pessoais_id');
    }
}
