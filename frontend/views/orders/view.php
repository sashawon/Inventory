<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */

$this->title = 'View Orders';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Print', ['print', 'id' => $model->order_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Download', ['download', 'id' => $model->order_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'order_id',
            'order_no',
//            'user_id',

            [
                'label' => 'User Name',
                'value' => function ($data){ return $data->user->username; },
            ],

            [
                'label' => 'Phone No',
                'value' => function ($data){ return $data->user->phone; },
            ],

            [
                'label' => 'Address',
                'value' => function ($data){ return $data->user->address; },
            ],

            'total_price',
            'status',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

    <?php 
    echo "<table class='table table-striped table-light mt-5'>
            <caption>table title and/or explanatory text</caption>
            <thead>
                <tr>
                    <th>orders_details_id</th>
                    <th>order_id</th>
                    <th>product_id</th>
                    <th>quantity</th>
                    <th>total_price</th>
                </tr>
            </thead>
            <tbody>";
    foreach($modelsOrdersDetails as $modelOrdersDetails){
        echo '
                <tr>
                    <td>'.$modelOrdersDetails->orders_details_id.'</td>
                    <td>'.$modelOrdersDetails->order_id.'</td>
                    <td>'.$modelOrdersDetails->product->name.'</td>
                    <td>'.$modelOrdersDetails->quantity.'</td>
                    <td>'.$modelOrdersDetails->total_price.'</td>
                </tr>
            ';
    }
    echo "</tbody>
        </table>";
    ?>

</div>
