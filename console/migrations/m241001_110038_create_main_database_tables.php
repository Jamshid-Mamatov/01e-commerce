<?php

use yii\db\Migration;

/**
 * Class m241001_110038_create_main_database_tables
 */
class m241001_110038_create_main_database_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "START transaction;

                CREATE TABLE `category` (
                                            `id` int PRIMARY KEY AUTO_INCREMENT,
                                            `name` varchar(255),
                                            `parent_id` int DEFAULT NULL,
                                            `description` text,
                                            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `product` (
                                           `id` int PRIMARY KEY AUTO_INCREMENT,
                                           `name` varchar(255),
                                           `is_active` bool DEFAULT true,
                                           `price` decimal(10,2),
                                           `is_discount` bool DEFAULT false,
                                           `discount_price` decimal(10,2),
                                           `stock` int DEFAULT 0,
                                           `description` text,
                                           `category_id` int,
                                           `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                           `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `review` (
                                          `id` int PRIMARY KEY AUTO_INCREMENT,
                                          `product_id` int,
                                          `user_id` int,
                                          `rating` int,
                                          `comment` text,
                                          `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `related_product` (
                                                   `product_id` int,
                                                   `related_product_id` int,
                                                   PRIMARY KEY (`product_id`, `related_product_id`)
                );
                
                CREATE TABLE `similar_product` (
                                                   `product_id` int,
                                                   `similar_product_id` int,
                                                   PRIMARY KEY (`product_id`, `similar_product_id`)
                );
                
                CREATE TABLE `recently_viewed_product` (
                                                           `user_id` int,
                                                           `product_id` int,
                                                           `viewed_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                                           PRIMARY KEY (`user_id`, `product_id`)
                );
                
                CREATE TABLE `attribute` (
                                             `id` int PRIMARY KEY AUTO_INCREMENT,
                                             `name` varchar(255) NOT NULL,
                                             `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `product_attribute_value` (
                                                           `id` int PRIMARY KEY AUTO_INCREMENT,
                                                           `product_id` int,
                                                           `attribute_id` int,
                                                           `value` varchar(255)
                );
                
                CREATE TABLE `cart` (
                                        `id` int PRIMARY KEY AUTO_INCREMENT,
                                        `user_id` int,
                                        `status` enum('active', 'checked_out', 'abandoned') DEFAULT 'active',
                                        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                        `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `cart_item` (
                                             `id` int PRIMARY KEY AUTO_INCREMENT,
                                             `cart_id` int,
                                             `order_id` int,
                                             `product_id` int,
                                             `quantity` int DEFAULT 1,
                                             `price` decimal(10,2),
                                             `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                             `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `order` (
                                         `id` int PRIMARY KEY AUTO_INCREMENT,
                                         `user_id` int,
                                         `status` enum('pending', 'confirmed', 'shipped', 'delivered', 'canceled') DEFAULT 'pending',
                                         `total_amount` decimal(10,2),
                                         `payment_status` enum('unpaid', 'paid') DEFAULT 'unpaid',
                                         `delivery_type` enum('standard', 'express', 'pickup'),
                                         `payment_type` enum('cash', 'credit_card', 'paypal', 'bank_transfer', 'click'),
                                         `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                         `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `product_images` (
                                                  `id` int PRIMARY KEY AUTO_INCREMENT,
                                                  `product_id` int,
                                                  `image_path` varchar(255),
                                                  `order` int DEFAULT 1,
                                                  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                                                  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE `product_translation` (
                                                       `id` int PRIMARY KEY AUTO_INCREMENT,
                                                       `product_id` int,
                                                       `language_code` varchar(255),
                                                       `title` varchar(255),
                                                       `description` text
                );
                
                CREATE TABLE `wishlist` (
                                            `id` int PRIMARY KEY AUTO_INCREMENT,
                                            `user_id` int DEFAULT NULL,
                                            `product_id` int
                );
                
                -- Foreign Keys
                
                ALTER TABLE `category` ADD FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`);
                
                ALTER TABLE `product` ADD FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
                
                ALTER TABLE `review` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `review` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
                
                ALTER TABLE `related_product` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `related_product` ADD FOREIGN KEY (`related_product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `similar_product` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `similar_product` ADD FOREIGN KEY (`similar_product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `recently_viewed_product` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
                
                ALTER TABLE `recently_viewed_product` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `product_attribute_value` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `product_attribute_value` ADD FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`);
                
                ALTER TABLE `cart` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
                
                ALTER TABLE `cart_item` ADD FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);
                
                ALTER TABLE `cart_item` ADD FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
                
                ALTER TABLE `order` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
                
                ALTER TABLE `product_images` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `product_translation` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                ALTER TABLE `wishlist` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
                
                ALTER TABLE `wishlist` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
                
                commit;";

        return $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241001_110038_create_main_database_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241001_110038_create_main_database_tables cannot be reverted.\n";

        return false;
    }
    */
}
