<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "price_history".
 *
 * @property int $id
 * @property int $pharmacy_id
 * @property int $drug_id
 * @property float $price_in
 * @property float $price_out
 * @property string|null $datetime
 *
 * @property Drug $drug
 * @property Pharmacy $pharmacy
 */
class PriceHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pharmacy_id', 'drug_id', 'price_in', 'price_out'], 'required'],
            [['pharmacy_id', 'drug_id'], 'default', 'value' => null],
            [['pharmacy_id', 'drug_id'], 'integer'],
            [['price_in', 'price_out'], 'number'],
            [['datetime'], 'safe'],
            [['drug_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drug::class, 'targetAttribute' => ['drug_id' => 'id']],
            [['pharmacy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pharmacy::class, 'targetAttribute' => ['pharmacy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pharmacy_id' => Yii::t('app', 'Pharmacy ID'),
            'drug_id' => Yii::t('app', 'Drug ID'),
            'price_in' => Yii::t('app', 'Price In'),
            'price_out' => Yii::t('app', 'Price Out'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * Gets query for [[Drug]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrug()
    {
        return $this->hasOne(Drug::class, ['id' => 'drug_id']);
    }

    /**
     * Gets query for [[Pharmacy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacy()
    {
        return $this->hasOne(Pharmacy::class, ['id' => 'pharmacy_id']);
    }
}
