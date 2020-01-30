<?php

use yii\db\Migration;

/**
 * Class m200130_054452_create_entities
 */
class m200130_054452_create_entities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'author_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()

        ]);
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk_author_to_book', 'book', 'author_id', 'author', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_author_to_book', 'book');
        $this->dropTable('author');
        $this->dropTable('book');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_054452_create_entities cannot be reverted.\n";

        return false;
    }
    */
}
