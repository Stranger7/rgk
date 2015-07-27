<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_101823_books extends Migration
{
    public function up()
    {
        $this->createTable('{{%books}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'date_create' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_update' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'image' => Schema::TYPE_STRING,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER,
        ]);

        $this->createIndex('books_author_id_idx', '{{%books}}', 'author_id');
        $this->addForeignKey(
            'FK_author_id', '{{%books}}', 'author_id', '{{%authors}}', 'id', 'SET NULL', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%books}}');
    }
}
