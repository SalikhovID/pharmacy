<?php

namespace common\service;

use common\models\Drug;
use common\models\DrugName;
use Yii;
use yii\data\SqlDataProvider;
use yii\db\Exception;

class DrugService
{
    public function getDrugModel(
        int $barcode,
        $pharmacy_id,
        $name,
        $country = null
    ): Drug
    {
        $model = Drug::findOne(['barcode' => $barcode]);
        if(is_null($model)){
            $model = new Drug;
            $model->barcode = $barcode;
            $model->country = $country;
            $model->save(false);


        }

        $drugName = DrugName::findOne(['drug_id' => $model->id, 'pharmacy_id' => $pharmacy_id]);
        if(is_null($drugName)){
            $nameModel = new DrugName();
            $nameModel->name = $name;
            $nameModel->drug_id = $model->id;
            $nameModel->pharmacy_id = $pharmacy_id;
            $nameModel->save(false);
        }

        return $model;
    }

    /**
     * @throws Exception
     */
    public function getDrugsByPharmacy($id, $type)
    {
        $params = [':id' => $id];
        $condition = match ($type){
            'l' => 'AND ROUND(((price_out - price_in) / price_in) * 100) < 20',
            'm' => 'AND ROUND(((price_out - price_in) / price_in) * 100) >= 20',
            default => ''
        };
        $sql = <<<SQL
            SELECT 
                d.id as drug_id,
                pd.pharmacy_id as pharmacy_id,
                dn.name as name,
                d.barcode as barcode,
                pd.price_in as price_in,
                pd.price_out as price_out,
                pd.count as count,
                pd.expiry_date as expiry_date,
                ROUND(((price_out - price_in) / price_in) * 100) AS percent
            FROM pharmacy_drug pd
            LEFT JOIN public.drug d on d.id = pd.drug_id
            LEFT JOIN public.drug_name dn on d.id = dn.drug_id and dn.pharmacy_id = pd.pharmacy_id
            WHERE pd.pharmacy_id = :id {$condition}
        SQL;

        $count = Yii::$app->db->createCommand(
            "SELECT COUNT(*) FROM pharmacy_drug WHERE pharmacy_id = :id {$condition}"
        , $params)->queryScalar();

        return new SqlDataProvider([
            'sql' => $sql,
            'params' => $params,
            'totalCount' => $count,

            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    public function getPriceHistory($drug_id, $pharmacy_id): \yii\db\DataReader|array
    {
        $params = [
            ':drug_id' => $drug_id,
            ':pharmacy_id' => $pharmacy_id
        ];
        $sql = <<<SQL
        select
            price_in,
            price_out,
            datetime as start,
            lag(datetime) over () as end,
            ROUND(((price_out - price_in) / price_in) * 100) AS percent
        from price_history
        where drug_id = :drug_id and pharmacy_id = :pharmacy_id
        group by price_in, price_out, datetime
        order by datetime desc
        SQL;
        return Yii::$app->db->createCommand($sql, $params)->queryAll();

    }
}