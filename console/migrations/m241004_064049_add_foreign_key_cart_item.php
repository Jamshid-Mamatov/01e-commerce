<?php

use yii\db\Migration;

/**
 * Class m241004_064049_add_foreign_key_cart_item
 */
class m241004_064049_add_foreign_key_cart_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_cart_item_order_id', 'cart_item', 'order_id', 'order', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241004_064049_add_foreign_key_cart_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241004_064049_add_foreign_key_cart_item cannot be reverted.\n";

        return false;
    }
    */
}
