<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pharmacy}}`.
 */
class m240220_151213_create_pharmacy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pharmacy}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pharmacy}}');
    }
}
