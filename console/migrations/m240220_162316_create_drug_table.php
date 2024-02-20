<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drug}}`.
 */
class m240220_162316_create_drug_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%drug}}', [
            'id' => $this->primaryKey(),
            'barcode' => $this->bigInteger()->notNull()->unique(),
            'country' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drug}}');
    }
}
