<?php

namespace common\service;

use common\models\Pharmacy;
use Yii;
use yii\db\Exception;

class PharmacyService
{
    public function getPharmacyModel(int $id): Pharmacy
    {
        $model = Pharmacy::findOne($id);
        if(is_null($model)){
            $model = new Pharmacy;
            $model->id = $id;
            $model->name = 'Pharmacy - ' . $id;
            $model->save(false);
        }
        return $model;
    }

    /**
     * @throws Exception
     */
    public function createPharmacyDrug(
        $pharmacy_id,
        $drug_id,
        $price_in,
        $price_out,
        $count,
        $expiry_date
    ): int
    {
        $paramsHistory = [
            ':pharmacy_id' => $pharmacy_id,
            ':drug_id' => $drug_id,
            ':price_in' => $price_in,
            ':price_out' => $price_out,

        ];
        $sqlHistory = "INSERT INTO price_history (pharmacy_id, drug_id, price_in, price_out)
             VALUES (:pharmacy_id, :drug_id, :price_in, :price_out)";

        $params = [
            ...$paramsHistory,
            ':count' => $count,
            ':expiry_date' => $expiry_date
        ];
        $sql = "INSERT INTO pharmacy_drug (pharmacy_id, drug_id, price_in, price_out, count, expiry_date)
             VALUES (:pharmacy_id, :drug_id, :price_in, :price_out, :count, :expiry_date)
             ON CONFLICT (drug_id, pharmacy_id, expiry_date) 
             DO UPDATE SET price_in = EXCLUDED.price_in, price_out = EXCLUDED.price_out, count = EXCLUDED.count";

        return Yii::$app->db
            ->createCommand($sql,$params)
            ->execute() && Yii::$app->db
            ->createCommand($sqlHistory,$paramsHistory)
            ->execute();
    }
}