<?php

use yii\db\Schema;

class m241004_050101_category extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'parent_id' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'FOREIGN KEY ([[parent_id]]) REFERENCES category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('category');
    }
}
