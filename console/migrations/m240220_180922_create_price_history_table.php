<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_history}}`.
 */
class m240220_180922_create_price_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%price_history}}', [
            'id' => $this->primaryKey(),
            'pharmacy_id' => $this->integer()->notNull(),
            'drug_id' => $this->integer()->notNull(),
            'price_in' => $this->float(2)->notNull(),
            'price_out' => $this->float(2)->notNull(),
            'datetime' => 'TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->createIndex(
            'idx-price_history-pharmacy_id',
            'price_history',
            'pharmacy_id',
        );

        $this->addForeignKey(
            'fk-price_history-pharmacy_id',
            'price_history',
            'pharmacy_id',
            'pharmacy',
            'id',
        );

        $this->createIndex(
            'idx-price_history-drug_id',
            'price_history',
            'drug_id',
        );

        $this->addForeignKey(
            'fk-price_history-drug_id',
            'price_history',
            'drug_id',
            'drug',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%price_history}}');
    }
}
