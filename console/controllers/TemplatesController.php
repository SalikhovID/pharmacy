<?php

namespace console\controllers;

use common\service\XmlService;
use yii\console\Controller;

class TemplatesController extends Controller
{
    public function actionIndex()
    {
        echo "Begin... \n\n\n";
        $xmlService = new XmlService();
        foreach ($xmlService->getListOfTmpXml() as $k => $item)
        {
            echo ($k) . " - start\n" . $item . "\n";
            $xmlService->xmlToDatabase($item);
            echo ($k) . " - end\n\n\n";
        }
        echo "\n\nEnd";
    }
}