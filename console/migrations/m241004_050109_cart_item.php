<?php

use yii\db\Schema;

class m241004_050109_cart_item extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('cart_item', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'quantity' => $this->integer()->defaultValue(1),
            'price' => $this->decimal(10,2),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'FOREIGN KEY ([[cart_id]]) REFERENCES cart ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
//            'FOREIGN KEY ([[order_id]]) REFERENCES order ([[id]]) ON DELETE  ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('cart_item');
    }
}
