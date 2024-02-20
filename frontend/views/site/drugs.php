<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Pharmacy $model */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Pharmacy';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => 'pharmacy'];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="site-about">
    <h1>Drugs</h1>
    <h2>
        <?= Html::a('All', ['drugs', 'id' => $model->id, 'type'=>'all'],['class' => 'btn btn-success']) ?>
        <?= Html::a('More than 20%', ['drugs', 'id' => $model->id, 'type'=>'m'],['class' => 'btn btn-danger']) ?>
        <?= Html::a('Less than 20%', ['drugs', 'id' => $model->id, 'type'=>'l'],['class' => 'btn btn-info']) ?>
    </h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'barcode',
            'price_in',
            'price_out',
            'count',
            [
                'attribute' => 'price_history',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('link',['price-history', 'drug_id' => $model['drug_id'], 'pharmacy_id' => $model['pharmacy_id']]);
                }
            ],
            'expiry_date',
            [
                'attribute' => 'percent',
                'value' => function ($model) {
                    return $model['percent'] . '%';
                }
            ]
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            // Check the condition for row color
            if ($model['percent'] >= 20) {
                return ['class' => 'table-danger'];
            }
            return [];
        },
    ]); ?>
</div>
