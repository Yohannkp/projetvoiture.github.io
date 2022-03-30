<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327124026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT NOT NULL, cni VARCHAR(255) NOT NULL, photo_identite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, nom_utilisateur VARCHAR(255) NOT NULL, mot_de_pass VARCHAR(255) NOT NULL, creer_le DATE DEFAULT NULL, creer_par VARCHAR(255) DEFAULT NULL, modifier_le DATE DEFAULT NULL, modifier_par VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, age DATE NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_FCEC9EFD60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT NOT NULL, poste VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, roleuser VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, voiture_id INT DEFAULT NULL, creer_le DATE DEFAULT NULL, creer_par VARCHAR(255) DEFAULT NULL, modifier_le DATE DEFAULT NULL, modifier_par VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, montant DOUBLE PRECISION NOT NULL, date_vente DATE NOT NULL, INDEX IDX_888A2A4C19EB6921 (client_id), UNIQUE INDEX UNIQ_888A2A4C181A8BA (voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, doctrine_id INT DEFAULT NULL, creer_le DATE DEFAULT NULL, creer_par VARCHAR(255) DEFAULT NULL, modifier_le DATE DEFAULT NULL, modifier_par VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, marque VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, num_serie VARCHAR(255) NOT NULL, numero_identifiant INT NOT NULL, date_achat DATE NOT NULL, couleur VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E9E2810F164640F (doctrine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F164640F FOREIGN KEY (doctrine_id) REFERENCES vente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4C19EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07BF396750');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFD60322AC');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F164640F');
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4C181A8BA');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE voiture');
    }
}
