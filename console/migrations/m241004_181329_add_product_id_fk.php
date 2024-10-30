<?php

use yii\db\Migration;

/**
 * Class m241004_181329_add_product_id_fk
 */
class m241004_181329_add_product_id_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            DELETE FROM cart_item
            WHERE product_id NOT IN (SELECT id FROM product)
        ");

        $this->addForeignKey(
            'fk-product_id',
            'cart_item',
            'product_id',
            'product',
            'id',
            'cascade',
            'cascade'

        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-cart_item-product_id',  // Name of the foreign key
            'cart_item'                 // The table from which the foreign key will be dropped
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241004_181329_add_product_id_fk cannot be reverted.\n";

        return false;
    }
    */
}
