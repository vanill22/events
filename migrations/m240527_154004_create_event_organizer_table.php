<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_organizer}}`.
 */
class m240527_154004_create_event_organizer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event_organizer}}', [
            'event_id' => $this->integer(),
            'organizer_id' => $this->integer(),
            'PRIMARY KEY(event_id, organizer_id)',
        ]);

        $this->addForeignKey(
            'fk-event_organizer-event_id',
            'event_organizer',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-event_organizer-organizer_id',
            'event_organizer',
            'organizer_id',
            'organizer',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event_organizer}}');
    }
}
