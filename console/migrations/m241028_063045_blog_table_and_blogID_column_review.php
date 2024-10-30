<?php

use yii\db\Migration;

/**
 * Class m241028_063045_blog_table_and_blogID_column_review
 */
class m241028_063045_blog_table_and_blogID_column_review extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'image'=>$this->string()->notNull(),
            'title'=>$this->string()->notNull(),
            'body'=>$this->text()->notNull(),
            'created_at'=>$this->timestamp(),
            'updated_at'=>$this->timestamp(),
        ]);
        $this->addForeignKey(
            'fk-blog-user_id',
            'blog',
            'user_id',
            'user',
            'id',
            'cascade',
            'cascade'
        );

        $this->addColumn('review', 'blog_id', $this->integer());
        $this->addForeignKey(
            'fk-review-blog_id',
            'review',
            'blog_id',
            'blog',
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
        echo "m241028_063045_blog_table_and_blogID_column_review cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_063045_blog_table_and_blogID_column_review cannot be reverted.\n";

        return false;
    }
    */
}
