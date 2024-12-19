<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217125043 extends AbstractMigration
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
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON app_user (login)');
        $this->addSql('ALTER INDEX uniq_8d93d64919eb6921 RENAME TO UNIQ_88BDF3E919EB6921');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455450FF010 ON client (telephone)');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT fk_831bc808a74d4963');
        //$this->addSql('DROP INDEX uniq_831bc808a74d4963');
        $this->addSql('ALTER TABLE dette DROP demande_dette_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE dette ADD demande_dette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT fk_831bc808a74d4963 FOREIGN KEY (demande_dette_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_831bc808a74d4963 ON dette (demande_dette_id)');
        $this->addSql('DROP INDEX UNIQ_C7440455450FF010');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_LOGIN');
        $this->addSql('ALTER INDEX uniq_88bdf3e919eb6921 RENAME TO uniq_8d93d64919eb6921');
    }
}
