<?php

use yii\db\Schema;

class m241004_050106_order extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status' => $this->string()->defaultValue('pending'),
            'total_amount' => $this->decimal(10,2),
            'payment_status' => $this->string()->defaultValue('unpaid'),
            'delivery_type' => $this->string(),
            'payment_type' => $this->string(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'FOREIGN KEY ([[user_id]]) REFERENCES user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('order');
    }
}
