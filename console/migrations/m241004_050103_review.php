<?php

use yii\db\Schema;

class m241004_050103_review extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'user_id' => $this->integer(),
            'rating' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->timestamp(),
            'FOREIGN KEY ([[product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[user_id]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'UNIQUE KEY `product_user_unique` (`product_id`, `user_id`)'
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('review');
    }
}
