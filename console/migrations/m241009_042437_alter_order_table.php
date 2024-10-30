<?php

use yii\db\Migration;

/**
 * Class m241009_042437_alter_order_table
 */
class m241009_042437_alter_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->addColumn('order','first_name',$this->string());
            $this->addColumn('order','last_name',$this->string());
            $this->addColumn('order','phone',$this->string());
            $this->addColumn('order','email',$this->string());
            $this->addColumn('order','country',$this->string());
            $this->addColumn('order','city',$this->string());
            $this->addColumn('order','address',$this->string());
            $this->addColumn('order','comment',$this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241009_042437_alter_order_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241009_042437_alter_order_table cannot be reverted.\n";

        return false;
    }
    */
}
