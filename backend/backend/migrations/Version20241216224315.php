<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216224315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dette_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE paiement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, qtestock INT NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN article.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, telephone VARCHAR(11) NOT NULL, surname VARCHAR(50) NOT NULL, adresse VARCHAR(100) NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455450FF010 ON client (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7769B0F ON client (surname)');
        $this->addSql('COMMENT ON COLUMN client.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, client_id INT NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, etat VARCHAR(255) NOT NULL, date_relance TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, montant_demande DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2694D7A519EB6921 ON demande (client_id)');
        $this->addSql('COMMENT ON COLUMN demande.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN demande.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE details (id INT NOT NULL, article_id INT NOT NULL, dette_id INT NOT NULL, demandes_dette_id INT DEFAULT NULL, qte_vendu INT NOT NULL, prix_vente DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_72260B8A7294869C ON details (article_id)');
        $this->addSql('CREATE INDEX IDX_72260B8AE11400A1 ON details (dette_id)');
        $this->addSql('CREATE INDEX IDX_72260B8AEF995C4A ON details (demandes_dette_id)');
        $this->addSql('CREATE TABLE dette (id INT NOT NULL, client_id INT DEFAULT NULL, demande_dette_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, montant_verser DOUBLE PRECISION NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_831BC80819EB6921 ON dette (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_831BC808A74D4963 ON dette (demande_dette_id)');
        $this->addSql('COMMENT ON COLUMN dette.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN dette.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE paiement (id INT NOT NULL, dette_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_paiement TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EE11400A1 ON paiement (dette_id)');
        $this->addSql('COMMENT ON COLUMN paiement.date_paiement IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, client_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, is_blocked BOOLEAN NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON "user" (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON "user" (login)');
        $this->addSql('COMMENT ON COLUMN "user".create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8AE11400A1 FOREIGN KEY (dette_id) REFERENCES dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8AEF995C4A FOREIGN KEY (demandes_dette_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC80819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC808A74D4963 FOREIGN KEY (demande_dette_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EE11400A1 FOREIGN KEY (dette_id) REFERENCES dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE details_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dette_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE paiement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A519EB6921');
        $this->addSql('ALTER TABLE details DROP CONSTRAINT FK_72260B8A7294869C');
        $this->addSql('ALTER TABLE details DROP CONSTRAINT FK_72260B8AE11400A1');
        $this->addSql('ALTER TABLE details DROP CONSTRAINT FK_72260B8AEF995C4A');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC80819EB6921');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC808A74D4963');
        $this->addSql('ALTER TABLE paiement DROP CONSTRAINT FK_B1DC7A1EE11400A1');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64919EB6921');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE details');
        $this->addSql('DROP TABLE dette');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE "user"');
    }
}
