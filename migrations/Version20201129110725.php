<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129110725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_880E0D76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_3F596DCCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encounter (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, tactic_arch_id INT DEFAULT NULL, date DATE NOT NULL, label_opposing_team VARCHAR(75) NOT NULL, category_opposing_team VARCHAR(50) NOT NULL, home INT DEFAULT NULL, visitor INT DEFAULT NULL, INDEX IDX_69D229CA296CD8AE (team_id), INDEX IDX_69D229CAF61B8FB2 (tactic_arch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, team_id INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, height INT DEFAULT NULL, weight INT DEFAULT NULL, injured TINYINT(1) NOT NULL, INDEX IDX_98197A65A76ED395 (user_id), INDEX IDX_98197A65296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, encounter_id INT DEFAULT NULL, player_id INT NOT NULL, red_card INT NOT NULL, yellow_card INT NOT NULL, pass_assist INT NOT NULL, goal INT NOT NULL, INDEX IDX_574767AAD6E2FADC (encounter_id), INDEX IDX_574767AA99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tactic (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, pos1_id INT DEFAULT NULL, pos2_id INT DEFAULT NULL, pos3_id INT DEFAULT NULL, pos4_id INT DEFAULT NULL, pos5_id INT DEFAULT NULL, pos6_id INT DEFAULT NULL, pos7_id INT DEFAULT NULL, pos8_id INT DEFAULT NULL, pos9_id INT DEFAULT NULL, pos10_id INT DEFAULT NULL, pos11_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_9FCCC8E4296CD8AE (team_id), INDEX IDX_9FCCC8E4E743AB23 (pos1_id), INDEX IDX_9FCCC8E4F5F604CD (pos2_id), INDEX IDX_9FCCC8E44D4A63A8 (pos3_id), INDEX IDX_9FCCC8E4D09D5B11 (pos4_id), INDEX IDX_9FCCC8E468213C74 (pos5_id), INDEX IDX_9FCCC8E47A94939A (pos6_id), INDEX IDX_9FCCC8E4C228F4FF (pos7_id), INDEX IDX_9FCCC8E49A4BE4A9 (pos8_id), INDEX IDX_9FCCC8E422F783CC (pos9_id), INDEX IDX_9FCCC8E4CC50782F (pos10_id), INDEX IDX_9FCCC8E474EC1F4A (pos11_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tactic_arch (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, pos1_id INT NOT NULL, pos2_id INT NOT NULL, pos3_id INT NOT NULL, pos4_id INT NOT NULL, pos5_id INT NOT NULL, pos6_id INT NOT NULL, pos7_id INT NOT NULL, pos8_id INT NOT NULL, pos9_id INT NOT NULL, pos10_id INT NOT NULL, pos11_id INT NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_A5F60C56296CD8AE (team_id), INDEX IDX_A5F60C56E743AB23 (pos1_id), INDEX IDX_A5F60C56F5F604CD (pos2_id), INDEX IDX_A5F60C564D4A63A8 (pos3_id), INDEX IDX_A5F60C56D09D5B11 (pos4_id), INDEX IDX_A5F60C5668213C74 (pos5_id), INDEX IDX_A5F60C567A94939A (pos6_id), INDEX IDX_A5F60C56C228F4FF (pos7_id), INDEX IDX_A5F60C569A4BE4A9 (pos8_id), INDEX IDX_A5F60C5622F783CC (pos9_id), INDEX IDX_A5F60C56CC50782F (pos10_id), INDEX IDX_A5F60C5674EC1F4A (pos11_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tactic_arch_substitute (tactic_arch_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_21CE07D0F61B8FB2 (tactic_arch_id), INDEX IDX_21CE07D099E6F5DF (player_id), PRIMARY KEY(tactic_arch_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tactic_arch_substituteOut (tactic_arch_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_3FB36718F61B8FB2 (tactic_arch_id), INDEX IDX_3FB3671899E6F5DF (player_id), PRIMARY KEY(tactic_arch_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, coach_id INT DEFAULT NULL, club_id INT NOT NULL, label VARCHAR(75) NOT NULL, category VARCHAR(50) NOT NULL, INDEX IDX_C4E0A61F3C105691 (coach_id), INDEX IDX_C4E0A61F61190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, date DATE NOT NULL, label VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_D5128A8F296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_missed (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, player_id INT NOT NULL, INDEX IDX_DF0E8CACBEFD98D1 (training_id), INDEX IDX_DF0E8CAC99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(75) NOT NULL, first_name VARCHAR(75) NOT NULL, birthday DATE NOT NULL, phone VARCHAR(15) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64961190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CAF61B8FB2 FOREIGN KEY (tactic_arch_id) REFERENCES tactic_arch (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AAD6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4E743AB23 FOREIGN KEY (pos1_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4F5F604CD FOREIGN KEY (pos2_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E44D4A63A8 FOREIGN KEY (pos3_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4D09D5B11 FOREIGN KEY (pos4_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E468213C74 FOREIGN KEY (pos5_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E47A94939A FOREIGN KEY (pos6_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4C228F4FF FOREIGN KEY (pos7_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E49A4BE4A9 FOREIGN KEY (pos8_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E422F783CC FOREIGN KEY (pos9_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E4CC50782F FOREIGN KEY (pos10_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic ADD CONSTRAINT FK_9FCCC8E474EC1F4A FOREIGN KEY (pos11_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56E743AB23 FOREIGN KEY (pos1_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56F5F604CD FOREIGN KEY (pos2_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C564D4A63A8 FOREIGN KEY (pos3_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56D09D5B11 FOREIGN KEY (pos4_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C5668213C74 FOREIGN KEY (pos5_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C567A94939A FOREIGN KEY (pos6_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56C228F4FF FOREIGN KEY (pos7_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C569A4BE4A9 FOREIGN KEY (pos8_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C5622F783CC FOREIGN KEY (pos9_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C56CC50782F FOREIGN KEY (pos10_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch ADD CONSTRAINT FK_A5F60C5674EC1F4A FOREIGN KEY (pos11_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tactic_arch_substitute ADD CONSTRAINT FK_21CE07D0F61B8FB2 FOREIGN KEY (tactic_arch_id) REFERENCES tactic_arch (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tactic_arch_substitute ADD CONSTRAINT FK_21CE07D099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tactic_arch_substituteOut ADD CONSTRAINT FK_3FB36718F61B8FB2 FOREIGN KEY (tactic_arch_id) REFERENCES tactic_arch (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tactic_arch_substituteOut ADD CONSTRAINT FK_3FB3671899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_missed ADD CONSTRAINT FK_DF0E8CACBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE training_missed ADD CONSTRAINT FK_DF0E8CAC99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64961190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F61190A32');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64961190A32');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3C105691');
        $this->addSql('ALTER TABLE stats DROP FOREIGN KEY FK_574767AAD6E2FADC');
        $this->addSql('ALTER TABLE stats DROP FOREIGN KEY FK_574767AA99E6F5DF');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4E743AB23');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4F5F604CD');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E44D4A63A8');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4D09D5B11');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E468213C74');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E47A94939A');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4C228F4FF');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E49A4BE4A9');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E422F783CC');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4CC50782F');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E474EC1F4A');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56E743AB23');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56F5F604CD');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C564D4A63A8');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56D09D5B11');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C5668213C74');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C567A94939A');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56C228F4FF');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C569A4BE4A9');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C5622F783CC');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56CC50782F');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C5674EC1F4A');
        $this->addSql('ALTER TABLE tactic_arch_substitute DROP FOREIGN KEY FK_21CE07D099E6F5DF');
        $this->addSql('ALTER TABLE tactic_arch_substituteOut DROP FOREIGN KEY FK_3FB3671899E6F5DF');
        $this->addSql('ALTER TABLE training_missed DROP FOREIGN KEY FK_DF0E8CAC99E6F5DF');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CAF61B8FB2');
        $this->addSql('ALTER TABLE tactic_arch_substitute DROP FOREIGN KEY FK_21CE07D0F61B8FB2');
        $this->addSql('ALTER TABLE tactic_arch_substituteOut DROP FOREIGN KEY FK_3FB36718F61B8FB2');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CA296CD8AE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('ALTER TABLE tactic DROP FOREIGN KEY FK_9FCCC8E4296CD8AE');
        $this->addSql('ALTER TABLE tactic_arch DROP FOREIGN KEY FK_A5F60C56296CD8AE');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F296CD8AE');
        $this->addSql('ALTER TABLE training_missed DROP FOREIGN KEY FK_DF0E8CACBEFD98D1');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76A76ED395');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCCA76ED395');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65A76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE stats');
        $this->addSql('DROP TABLE tactic');
        $this->addSql('DROP TABLE tactic_arch');
        $this->addSql('DROP TABLE tactic_arch_substitute');
        $this->addSql('DROP TABLE tactic_arch_substituteOut');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_missed');
        $this->addSql('DROP TABLE user');
    }
}
