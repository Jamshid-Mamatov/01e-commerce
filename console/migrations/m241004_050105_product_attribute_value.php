<?php

use yii\db\Schema;

class m241004_050105_product_attribute_value extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('product_attribute_value', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->string(255),
            'FOREIGN KEY ([[product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[attribute_id]]) REFERENCES attribute ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('product_attribute_value');
    }
}
