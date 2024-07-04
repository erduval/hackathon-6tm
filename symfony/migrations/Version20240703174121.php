<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703174121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, coopteur_id INT NOT NULL, offre_emploi_id INT NOT NULL, cv LONGBLOB NOT NULL, lien VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_E33BD3B884CDB096 (coopteur_id), INDEX IDX_E33BD3B8B08996ED (offre_emploi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classement (id INT AUTO_INCREMENT NOT NULL, equipe_id INT NOT NULL, position INT NOT NULL, nom_equipe VARCHAR(255) NOT NULL, points INT NOT NULL, INDEX IDX_55EE9D6D6D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cooptation (id INT AUTO_INCREMENT NOT NULL, date_cooptation DATE NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cooptation_offre_emploi (id INT AUTO_INCREMENT NOT NULL, cooptation_id INT NOT NULL, INDEX IDX_930D07CA700D5 (cooptation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coopteur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, points INT NOT NULL, UNIQUE INDEX UNIQ_CABADEFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_utilisateur (id INT AUTO_INCREMENT NOT NULL, equipe_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_D78C92636D861B89 (equipe_id), INDEX IDX_D78C9263FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, rh_id INT NOT NULL, message LONGTEXT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_BF5476CA22A2877C (rh_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_publication DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rh (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_1FB9E0E1FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B884CDB096 FOREIGN KEY (coopteur_id) REFERENCES coopteur (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8B08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE cooptation_offre_emploi ADD CONSTRAINT FK_930D07CA700D5 FOREIGN KEY (cooptation_id) REFERENCES cooptation (id)');
        $this->addSql('ALTER TABLE coopteur ADD CONSTRAINT FK_CABADEFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE equipe_utilisateur ADD CONSTRAINT FK_D78C92636D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE equipe_utilisateur ADD CONSTRAINT FK_D78C9263FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA22A2877C FOREIGN KEY (rh_id) REFERENCES rh (id)');
        $this->addSql('ALTER TABLE rh ADD CONSTRAINT FK_1FB9E0E1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B884CDB096');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8B08996ED');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D6D861B89');
        $this->addSql('ALTER TABLE cooptation_offre_emploi DROP FOREIGN KEY FK_930D07CA700D5');
        $this->addSql('ALTER TABLE coopteur DROP FOREIGN KEY FK_CABADEFB88E14F');
        $this->addSql('ALTER TABLE equipe_utilisateur DROP FOREIGN KEY FK_D78C92636D861B89');
        $this->addSql('ALTER TABLE equipe_utilisateur DROP FOREIGN KEY FK_D78C9263FB88E14F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA22A2877C');
        $this->addSql('ALTER TABLE rh DROP FOREIGN KEY FK_1FB9E0E1FB88E14F');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE classement');
        $this->addSql('DROP TABLE cooptation');
        $this->addSql('DROP TABLE cooptation_offre_emploi');
        $this->addSql('DROP TABLE coopteur');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_utilisateur');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE rh');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE utilisateur');
    }
}
