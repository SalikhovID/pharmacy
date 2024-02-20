<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drug_name}}`.
 */
class m240220_165329_create_drug_name_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%drug_name}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'drug_id' => $this->integer()->notNull(),
            'pharmacy_id' => $this->integer()->notNull()
        ]);

        $this->execute('ALTER TABLE {{%drug_name}} ADD UNIQUE (drug_id, pharmacy_id)');

        $this->createIndex(
            'idx-drug_name-drug_id',
            'drug_name',
            'drug_id',
        );

        $this->addForeignKey(
            'fk-drug_name-drug_id',
            'drug_name',
            'drug_id',
            'drug',
            'id',
        );

        $this->createIndex(
            'idx-drug_name-pharmacy_id',
            'drug_name',
            'pharmacy_id',
        );

        $this->addForeignKey(
            'fk-drug_name-pharmacy_id',
            'drug_name',
            'pharmacy_id',
            'pharmacy',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drug_name}}');
    }
}
