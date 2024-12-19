<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217123429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, client_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, is_blocked BOOLEAN NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E919EB6921 ON app_user (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON app_user (login)');
        $this->addSql('COMMENT ON COLUMN app_user.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d64919eb6921');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT fk_831bc808a74d4963');
        $this->addSql('DROP INDEX uniq_831bc808a74d4963');
        $this->addSql('ALTER TABLE dette DROP demande_dette_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, client_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, is_blocked BOOLEAN NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_login ON "user" (login)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d64919eb6921 ON "user" (client_id)');
        $this->addSql('COMMENT ON COLUMN "user".create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d64919eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E919EB6921');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('ALTER TABLE dette ADD demande_dette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT fk_831bc808a74d4963 FOREIGN KEY (demande_dette_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_831bc808a74d4963 ON dette (demande_dette_id)');
    }
}
