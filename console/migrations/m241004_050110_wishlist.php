<?php

use yii\db\Schema;

class m241004_050110_wishlist extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('wishlist', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer(),
            'FOREIGN KEY ([[user_id]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('wishlist');
    }
}
