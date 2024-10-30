<?php

use yii\db\Migration;

/**
 * Class m241017_085047_add_approved_column_to_review
 */
class m241017_085047_add_approved_column_to_review extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%review}}', 'approved', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%review}}', 'approved');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241017_085047_add_approved_column_to_review cannot be reverted.\n";

        return false;
    }
    */
}
