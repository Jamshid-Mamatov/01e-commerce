<?php

use yii\db\Schema;

class m241004_050102_product extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'is_active' => $this->boolean()->defaultValue(true),
            'price' => $this->decimal(10,2),
            'is_discount' => $this->boolean()->defaultValue(0),
            'discount_price' => $this->decimal(10,2),
            'stock' => $this->integer()->defaultValue(0),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'FOREIGN KEY ([[category_id]]) REFERENCES category ([[id]]) ON DELETE SET NULL ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
}
