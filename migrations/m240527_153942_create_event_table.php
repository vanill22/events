<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m240527_153942_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'date' => $this->date(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
