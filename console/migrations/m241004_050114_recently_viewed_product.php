<?php

use yii\db\Schema;

class m241004_050114_recently_viewed_product extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('recently_viewed_product', [
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'viewed_at' => $this->timestamp(),
            'PRIMARY KEY ([[user_id]], [[product_id]])',
            'FOREIGN KEY ([[user_id]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[product_id]]) REFERENCES product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('recently_viewed_product');
    }
}
