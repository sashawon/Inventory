<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'order_no',
            'user_id',
            'total_price',
            // 'status',
            //'created_at',
            //'updated_at',

            $buttons = [
                'label' => 'Payment',
//                'format' => 'raw',
                'value' => Html::a('Create Orders', ['create'], ['class' => 'btn btn-success'])
            ],


            'buttons' => [
                'label' => 'Payment',
                'value' => function ($url, $model) {
                    return Html::a('Payment', ['invoice/create', 'id'=>'1'], ['class' => 'btn btn-success']);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
