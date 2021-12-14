<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */

// echo"<pre>"; var_dump($model); 
// echo"<pre>"; var_dump($modelsOrdersDetails); die();

foreach($model as $models){
    // echo"<pre>"; print_r($models); 
}

foreach($modelsOrdersDetails as $modelsOrdersDetail){
    // echo"<pre>"; print_r($modelsOrdersDetail); 
}
    // die();


$this->title = 'Invoice No: ' . $models['order_no'];
$this->params['breadcrumbs'][] = ['label' => $models['order_no']];
$this->params['breadcrumbs'][] = 'Invoice';
?>
<div class="orders-invoice">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php
                    echo "<table class='table table-striped table-light'>
                            <p><b>Order Information</b></p><hr>
                            <tbody>";
                foreach($model as $models){
                    echo '
                            <tr>
                                <td>Order No</td>
                                <td>'.$models->order_no.'</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>'.$models->created_at.'</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>'.$models->status.'</td>
                            </tr>
                        ';
                }
                    echo"</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6">
                <?php
                    echo "<table class='table table-striped table-light'>
                            <p><b>User Information</b></p><hr>
                            <tbody>";
                foreach($model as $models){
                    echo '
                            <tr>
                                <td>Name</td>
                                <td>'.$models->user->username.'</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>'.$models->user->address.'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>'.$models->user->email.'</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>'.$models->user->phone.'</td>
                            </tr>
                        ';
                }
                    echo "</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-12 mt-5">
                <?php
                    $i = 1;

                    echo "<table class='table table-striped table-light'>
                            <p><b>Items Invoiced</b></p><hr>
                            <thead>
                                <tr>
                                    <td>SL.</td>
                                    <td>Product Name</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                </tr>
                            </thead>
                            <tbody>";
                foreach($modelsOrdersDetails as $modelsOrdersDetail){
                    echo '
                            <tr>
                                <td>'.$i++.'</td>
                                <td>'.$modelsOrdersDetail->product->name.'</td>
                                <td>'.$modelsOrdersDetail->quantity.'</td>
                                <td>'.$modelsOrdersDetail->total_price.'</td>
                            </tr>
                        ';
                }
                    echo "</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6"></div>
            <div class="col-6 mt-5">
                <?php
                    echo "<table class='table table-striped table-light'>
                            <p><b>Invoice Total</b></p><hr>
                            <tbody>";
                foreach($model as $models){
                    echo '
                            <tr>
                                <td>Total Price</td>
                                <td>'.$models->total_price.'</td>
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
