<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */


$this->title = 'Total Orders';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Order Information', 'url' => ['/orders/order_info', 'id' => Yii::$app->user->identity->user_id]];
?>
<div class="orders-invoice">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php 
                echo "<table class='table table-striped table-light'>
                        <p><b>User Information</b></p><hr>
                        <tbody>
                            <tr>
                                <th>User Name</th>
                                <td>".$userInfo->username."</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>".$userInfo->phone."</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>".$userInfo->email."</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>".$userInfo->address."</td>
                            </tr>
                        </tbody>
                    </table>";
                ?> 
            </div>
            <div class="col-12 mt-5">
                <?php 
                echo "<table class='table table-striped table-light'>
                        <p><b>Total Order Information</b></p><hr>
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach($model as $models){
                    // echo "<pre>";
                    // var_dump($models);
                    // die();
                    echo '
                            <tr>
                                <td>'.$models->order_no.'</td>
                                <td>'.$models->total_price.'</td>
                                <td>'.$models->status.'</td>
                                <td>'.$models->created_at.'</td>
                                <td>'.Html::a('Details', ['/orders/order_items_details/'.$models->order_id], ['class'=>'btn btn-primary']).'</td>
                            </tr>
                        ';
                }
                echo "</tbody>
                    </table>";
                ?>                
            </div>
        </div>
    </div>


</div>
