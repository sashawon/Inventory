<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type=='admin'){
            echo Html::a('Create Product', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'product_id',
            'name',
            'photo',
            'price',
            'quantity',
            //'details:ntext',
            [
                'attribute' => 'status',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->user_type=='admin',
            ],
            //'status',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->user_type=='admin',
            ],
        ],
    ]); ?>


</div>
