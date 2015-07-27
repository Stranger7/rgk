<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_100406_authors extends Migration
{
    public function up()
    {
        $this->createTable('{{%authors}}', [
            'id' => Schema::TYPE_PK,
            'firstname' => Schema::TYPE_STRING . ' NOT NULL',
            'lastname' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->createIndex('authors_firstname_lastname_unique_idx',
            '{{%authors}}',
            ['firstname', 'lastname'],
            true
        );
    }

    public function down()
    {
        $this->dropTable('{{%authors}}');
    }
}
