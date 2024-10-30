<?php

use yii\db\Migration;

/**
 * Class m241018_105450_back_fk
 */
class m241018_105450_back_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Re-add foreign key for product_id
        $this->addForeignKey(
            'fk_review_product_id',  // Foreign key name
            'review',                // Table where the key is added
            'product_id',            // Column in the review table
            'product',               // Referenced table
            'id',                    // Column in the referenced table
            'CASCADE',               // On delete
            'CASCADE'                // On update
        );

        // Re-add foreign key for user_id
        $this->addForeignKey(
            'fk_review_user_id',     // Foreign key name
            'review',                // Table where the key is added
            'user_id',               // Column in the review table
            'user',                  // Referenced table
            'id',                    // Column in the referenced table
            'CASCADE',               // On delete
            'CASCADE'                // On update
        );
    }

    public function safeDown()
    {
        // Drop foreign key for product_id if rolling back
        $this->dropForeignKey('fk_review_product_id', 'review');

        // Drop foreign key for user_id if rolling back
        $this->dropForeignKey('fk_review_user_id', 'review');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241018_105450_back_fk cannot be reverted.\n";

        return false;
    }
    */
}
