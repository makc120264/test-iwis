<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250506114621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Mysql tables category and product';
    }

    public function up(Schema $schema): void
    {
        $categorySql = "CREATE TABLE `category` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `name` (`name`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->addSql($categorySql);

        $productSql = "CREATE TABLE `product` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
                          `price` double NOT NULL,
                          `category_id` int NOT NULL,
                          PRIMARY KEY (`id`),
                          KEY `fk_product_category` (`category_id`),
                          CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->addSql($productSql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE category;");
        $this->addSql("DROP TABLE product;");
    }
}
