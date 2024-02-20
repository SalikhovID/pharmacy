<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drug".
 *
 * @property int $id
 * @property int $barcode
 * @property string|null $country
 *
 * @property DrugName[] $drugNames
 * @property Pharmacy[] $pharmacies
 */
class Drug extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drug';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barcode'], 'required'],
            [['barcode'], 'default', 'value' => null],
            [['barcode'], 'integer'],
            [['country'], 'string', 'max' => 255],
            [['barcode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'barcode' => Yii::t('app', 'Barcode'),
            'country' => Yii::t('app', 'Country'),
        ];
    }

    /**
     * Gets query for [[DrugNames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugNames()
    {
        return $this->hasMany(DrugName::class, ['drug_id' => 'id']);
    }

    /**
     * Gets query for [[Pharmacies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacies()
    {
        return $this->hasMany(Pharmacy::class, ['id' => 'pharmacy_id'])->viaTable('drug_name', ['drug_id' => 'id']);
    }
}
