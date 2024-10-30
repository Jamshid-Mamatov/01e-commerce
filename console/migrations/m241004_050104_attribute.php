<?php

use yii\db\Schema;

class m241004_050104_attribute extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('attribute', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp(),
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('attribute');
    }
}
