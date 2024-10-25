<?php

use yii\db\Migration;


class m241025_120431_update_guests_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('guests', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'surname' => $this->string(100)->notNull(),
            'email' => $this->string(100)->unique(),
            'phone' => $this->string(20)->unique()->notNull(),
            'country' => $this->string(50),
        ]);
    }


    public function safeDown()
    {
        $this->dropTable('{{%guests}}');
    }
}
