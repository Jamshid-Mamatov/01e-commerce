<?php

use yii\db\Schema;

class m241004_050113_similiar_product extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('similar_product', [
            'product_id' => $this->integer()->notNull(),
            'similar_product_id' => $this->integer()->notNull(),
            'PRIMARY KEY ([[product_id]], [[similar_product_id]])',
            'FOREIGN KEY ([[similar_product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('similar_product');
    }
}
