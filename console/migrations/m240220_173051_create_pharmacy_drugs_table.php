<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pharmacy_drug}}`.
 */
class m240220_173051_create_pharmacy_drugs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pharmacy_drug}}', [
            'id' => $this->primaryKey(),
            'pharmacy_id' => $this->integer()->notNull(),
            'drug_id' => $this->integer()->notNull(),
            'price_in' => $this->float(2)->notNull(),
            'price_out' => $this->float(2)->notNull(),
            'count' => $this->float(6)->notNull(),
            'expiry_date' => $this->date()->notNull()
        ]);

        $this->createIndex(
            'idx-pharmacy_drug-pharmacy_id',
            'pharmacy_drug',
            'pharmacy_id',
        );

        $this->addForeignKey(
            'fk-pharmacy_drug-pharmacy_id',
            'pharmacy_drug',
            'pharmacy_id',
            'pharmacy',
            'id',
        );

        $this->createIndex(
            'idx-pharmacy_drug-drug_id',
            'pharmacy_drug',
            'drug_id',
        );

        $this->addForeignKey(
            'fk-pharmacy_drug-drug_id',
            'pharmacy_drug',
            'drug_id',
            'drug',
            'id',
        );

        $this->execute('ALTER TABLE {{%pharmacy_drug}} ADD UNIQUE (drug_id, pharmacy_id, expiry_date)');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pharmacy_drugs}}');
    }
}
