<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'invoice_id',
            'invoice_no',
            //'order_id',
            [
                'label' => 'Order No',
                'value' => function ($data){ return $data->orders->order_no; },
            ],
            //'customer_id',
            [
                'label' => 'User Name',
                'value' => function ($data){ return $data->user->username; },
            ],
            //'paid_amount',
            [
                'label' => 'Paid Amount',
                'attribute' => 'paid_amount',
                'value' => function ($data){ return $data->paid_amount." ৳"; },
            ],
            'comment:ntext',
            'payment_date',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{view}'
            ],
        ],
    ]); ?>


</div>
