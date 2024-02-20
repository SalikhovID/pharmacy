<?php

namespace common\service;

use DateTime;
use Yii;
use yii\helpers\FileHelper;

class XmlService
{

    public function xmlToDatabase($path): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $id = $this->getPharmacyIdFromPath($path);
            $pharmacyService = new PharmacyService();
            $pharmacy = $pharmacyService->getPharmacyModel($id);
            $pharmacy_id = $pharmacy->id;
            $drugService = new DrugService();
            foreach ($this->xmlFileToArray($path) as $item)
            {
                $array = $item['@attributes'];
                $drug = $drugService->getDrugModel(
                    (int) $array['B'],
                    $pharmacy_id,
                    $array['N'],
                    $array['P'] ?? null
                );
                $pharmacyService->createPharmacyDrug(
                    $pharmacy_id,
                    $drug->id,
                    $array['S'],
                    $array['G'],
                    $array['K'],
                    $this->dateFormat($array['E']),
                );
            }
            rename($path, Yii::getAlias('@xml/archive/'.$id.'_'.time().'.xml'));
            $transaction->commit();
            return true;
        }catch (\Exception $exception){
            $transaction->rollBack();
            return false;
        }

    }

    private function getPharmacyIdFromPath($path): int
    {
        $array =  explode('/', $path);
        $file_name = explode('_',substr($array[array_key_last($array)],0,-4));
        return (int)$file_name[1];
    }

    public function getListOfTmpXml(): array
    {
        $list = FileHelper::findFiles(Yii::getAlias('@xml/tmp'));
        foreach ($list as $k => $v){
            if(!str_ends_with(strtolower($v), '.xml')){
                unset($list[$k]);
            }
        }
        return $list;
    }

    public function xmlFileToArray($path)
    {
        $xmlFile = Yii::getAlias($path);
        $xmlString = file_get_contents($xmlFile);
        $xmlString = utf8_encode($xmlString);
        $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array['B'];
    }

    private function dateFormat($date): string
    {
        return DateTime::createFromFormat('Y/m/d', $date)->format('Y-m-d');
    }
}