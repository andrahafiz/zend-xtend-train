<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226064443 extends AbstractMigration
{
    public function up(Schema $schema): void
    {

        // // this up() migration is auto-generated, please modify it to your needs
        // $createTable = <<<SQL
        //         CREATE TABLE `university` (
        //         `uuid` VARCHAR(36) NOT NULL,
        //         `name` VARCHAR(100) NULL ,
        //         `address` VARCHAR(100) NULL DEFAULT NULL,
        //         `logo` VARCHAR(200) NULL DEFAULT NULL,
        //         `description` VARCHAR(200) NULL DEFAULT NULL,
        //         `created_at` DATETIME NULL ,
        //         `updated_at` DATETIME NULL DEFAULT NULL,
        //         `deleted_at` DATETIME NULL DEFAULT NULL,
        //         PRIMARY KEY (`uuid`))
        //         ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        //         COMMIT;
        //         SQL;
        // $this->addSql($createTable);

        // $createTable = <<<SQL
        //         CREATE TABLE `faculty` (
        //         `uuid` VARCHAR(36) NOT NULL,
        //         `university_uuid` VARCHAR(36) NULL DEFAULT NULL,
        //         `name` VARCHAR(100) NULL DEFAULT NULL,
        //         `description` VARCHAR(200) NULL DEFAULT NULL,
        //         `created_at` DATETIME NULL,
        //         `updated_at` DATETIME NULL DEFAULT NULL,
        //         `deleted_at` DATETIME NULL DEFAULT NULL,
        //         PRIMARY KEY (`uuid`),
        //         INDEX `faculty_university_idx` (`university_uuid` ASC),
        //         CONSTRAINT `fk_faculty_university`
        //         FOREIGN KEY (`university_uuid`)
        //         REFERENCES `university` (`uuid`)
        //         ON DELETE SET NULL
        //         ON UPDATE NO ACTION)
        //         ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        //         COMMIT;
        //         SQL;
        // $this->addSql($createTable);

        // $createTable = <<<SQL
        //         CREATE TABLE `major` (
        //             `uuid` VARCHAR(36) NOT NULL,
        //             `faculty_uuid` VARCHAR(36) NULL DEFAULT NULL,
        //             `name` VARCHAR(100) NULL DEFAULT NULL,
        //             `description` VARCHAR(45) NULL DEFAULT NULL,
        //             `created_at` DATETIME NULL,
        //             `updated_at` DATETIME NULL DEFAULT NULL,
        //             `deleted_at` DATETIME NULL DEFAULT NULL,
        //             PRIMARY KEY (`uuid`),
        //             INDEX `major_faculty_idx` (`faculty_uuid` ASC),
        //             CONSTRAINT `fk_major_faculty`
        //                 FOREIGN KEY (`faculty_uuid`)
        //                 REFERENCES `faculty` (`uuid`)
        //                 ON DELETE SET NULL
        //                 ON UPDATE NO ACTION)
        //                 ENGINE=InnoDB DEFAULT 
        //                 CHARSET=utf8 
        //                 COLLATE=utf8_unicode_ci;
        //         COMMIT;
        //         SQL;
        // $this->addSql($createTable);

        // $createTable = <<<SQL
        //         CREATE TABLE `room` (
        //         `uuid` VARCHAR(36) NOT NULL,
        //         `major_uuid` VARCHAR(36) NULL DEFAULT NULL,
        //         `code` VARCHAR(45) NULL DEFAULT NULL,
        //         `isClassroom` VARCHAR(45) NULL DEFAULT '1',
        //         `created_at` DATETIME NULL DEFAULT NULL,
        //         `updated_at` DATETIME NULL,
        //         `deleted_at` VARCHAR(45) NULL,
        //         PRIMARY KEY (`uuid`),
        //         INDEX `room_major_idx` (`major_uuid` ASC),
        //         CONSTRAINT `fk_room_major`
        //             FOREIGN KEY (`major_uuid`)
        //             REFERENCES `major` (`uuid`)
        //             ON DELETE SET NULL
        //             ON UPDATE NO ACTION)
                    
        //                 ENGINE=InnoDB DEFAULT 
        //                 CHARSET=utf8 
        //                 COLLATE=utf8_unicode_ci;
        //         COMMIT;
        //         SQL;
        // $this->addSql($createTable);

        // $createTable = <<<SQL
        //         CREATE TABLE `schedule` (
        //             `uuid` VARCHAR(36)  NOT NULL,
        //             `led_by_uuid` VARCHAR(36)  NULL DEFAULT NULL,
        //             `room_uuid` VARCHAR(36)  NULL DEFAULT NULL,
        //             `startTime` DATETIME NULL DEFAULT NULL,
        //             `endTime` DATETIME NULL DEFAULT NULL,
        //             `topic` VARCHAR(100)  NULL DEFAULT NULL,
        //             `description` VARCHAR(200)  NULL DEFAULT NULL,
        //             `created_at` DATETIME NULL,
        //             `updated_at` DATETIME NULL DEFAULT NULL,
        //             `deleted_at` DATETIME NULL DEFAULT NULL,
        //             PRIMARY KEY (`uuid`),
        //             INDEX `schedule_led_by_idx` (`led_by_uuid` ASC),
        //             INDEX `schedule_room_idx` (`room_uuid` ASC),
        //             INDEX `fk_schedule_led_by_idx` (`led_by_uuid` ASC, `room_uuid` ASC),
        //             CONSTRAINT `fk_schedule_led_by`
        //             FOREIGN KEY (`led_by_uuid`)
        //             REFERENCES `user_profile` (`uuid`)
        //             ON DELETE SET NULL
        //             ON UPDATE NO ACTION,
        //             CONSTRAINT `fk_schedule_room`
        //             FOREIGN KEY (`room_uuid`)
        //             REFERENCES `room` (`uuid`)
        //             ON DELETE SET NULL
        //             ON UPDATE NO ACTION)
        //                 ENGINE=InnoDB DEFAULT 
        //                 CHARSET=utf8 
        //                 COLLATE=utf8_unicode_ci;
        //         COMMIT;
        //         SQL;
        // $this->addSql($createTable);
    }


    public function down(Schema $schema): void
    {
        // $createTable = <<<SQL
        // SET FOREIGN_KEY_CHECKS = 0 ;
        // DROP TABLE`schedule`,
        // `room`,
        // `major`,
        // `faculty`,
        // `university`;
        // COMMIT;
        // SQL;
        // $this->addSql($createTable);
    }
}
