<?php

use yii\db\Migration;

/**
 * Class m241010_091901_advertisement_tables
 */
class m241010_091901_advertisement_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('{{%advertisement}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'type' => $this->string()->notNull(),
                'start_date' => $this->date()->notNull(),
                'end_date' => $this->date()->notNull(),
            ]);
            $this->createTable('{{%advertisement_categories}}', [
                'id' => $this->primaryKey(),
                'category_id' => $this->integer()->unique(),
                'advertisement_id' => $this->integer()

            ]);
            $this->addForeignKey(
                'fk-advertisement_categories-category_id',
                '{{%advertisement_categories}}',
                'category_id',
                '{{%category}}',
                'id',
                'CASCADE',
                'CASCADE'


            );
            $this->addForeignKey(
                'fk-advertisement_categories-advertisement_id',
                '{{%advertisement_categories}}',
                'advertisement_id',
                '{{%advertisement}}',
                'id',
                'CASCADE',
                'CASCADE'
            );

            $this->createTable('{{%advertisement_products}}', [
                'id' => $this->primaryKey(),
                'advertisement_id' => $this->integer(),
                'product_id' => $this->integer()->unique(),

            ]);
            $this->addForeignKey(
                'fk-advertisement_products-advertisement_id',
                '{{%advertisement_products}}',
                'advertisement_id',
                '{{%advertisement}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-advertisement_products-product_id',
                '{{%advertisement_products}}',
                'product_id',
                '{{%product}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241010_091901_advertisement_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241010_091901_advertisement_tables cannot be reverted.\n";

        return false;
    }
    */
}
