<?php

use yii\db\Schema;

class m241004_050107_product_translation extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('product_translation', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'language_code' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->text(),
            'FOREIGN KEY ([[product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('product_translation');
    }
}
