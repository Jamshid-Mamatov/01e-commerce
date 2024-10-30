<?php

use yii\db\Migration;

/**
 * Class m241026_061709_add_address_field_to_user
 */
class m241026_061709_add_address_field_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','city',$this->string());
        $this->addColumn('user','state',$this->string());
        $this->addColumn('user','country',$this->string());
        $this->addColumn('user','zip',$this->string());
        $this->addColumn('user','birthdate',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241026_061709_add_address_field_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241026_061709_add_address_field_to_user cannot be reverted.\n";

        return false;
    }
    */
}
