<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drug_name".
 *
 * @property int $id
 * @property string $name
 * @property int $drug_id
 * @property int $pharmacy_id
 *
 * @property Drug $drug
 * @property Pharmacy $pharmacy
 */
class DrugName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drug_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'drug_id', 'pharmacy_id'], 'required'],
            [['drug_id', 'pharmacy_id'], 'default', 'value' => null],
            [['drug_id', 'pharmacy_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['drug_id', 'pharmacy_id'], 'unique', 'targetAttribute' => ['drug_id', 'pharmacy_id']],
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
            'name' => Yii::t('app', 'Name'),
            'drug_id' => Yii::t('app', 'Drug ID'),
            'pharmacy_id' => Yii::t('app', 'Pharmacy ID'),
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
