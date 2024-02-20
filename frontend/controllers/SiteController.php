<?php

namespace frontend\controllers;

use common\models\Pharmacy;
use common\models\PriceHistory;
use common\service\DrugService;
use frontend\models\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }


    public function actionIndex(): string
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->myFile = UploadedFile::getInstance($model, 'myFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->render('success');
            }
        }

        return $this->render('index', ['model' => $model]);
    }

    public function actionPharmacy(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pharmacy::find(),
        ]);

        return $this->render('pharmacy', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws NotFoundHttpException|Exception
     */
    public function actionDrugs($id, $type): string
    {
        $model = Pharmacy::findOne($id);
        if(is_null($model)){
            throw new NotFoundHttpException();
        }

        return $this->render('drugs',[
            'dataProvider' => (new DrugService())->getDrugsByPharmacy($id, $type),
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionPriceHistory($drug_id, $pharmacy_id): string
    {
        $check = PriceHistory::findOne(['drug_id' => $drug_id, 'pharmacy_id' => $pharmacy_id]);
        if(is_null($check)){
            throw new NotFoundHttpException();
        }

        return $this->render('price-history',[
            'data' => (new DrugService())->getPriceHistory($drug_id, $pharmacy_id)
        ]);
    }

}
