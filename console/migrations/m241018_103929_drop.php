<?php

use yii\db\Migration;

/**
 * Class m241018_103929_drop
 */
class m241018_103929_drop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        // Drop foreign keys
        $this->dropForeignKey('review_ibfk_1', 'review');
        $this->dropForeignKey('review_ibfk_2', 'review');

        // Drop unique index
        $this->dropIndex('product_user_unique', 'review');
    }

    public function down()
    {
        // Recreate the unique index if needed
        $this->createIndex('product_user_unique', 'review', ['product_id', 'user_id'], true);

        // Recreate foreign keys
        $this->addForeignKey('fk_review_product_id', 'review', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_review_user_id', 'review', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241018_103929_drop cannot be reverted.\n";

        return false;
    }
    */
}
