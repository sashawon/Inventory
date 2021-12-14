<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Invoice */


$this->title = $modelInvoiceDetails[0]->invoice_id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Print', ['#'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Download', ['#'], ['class' => 'btn btn-danger']) ?>
    </p>


    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>Order Information</b></p><hr>
                            <tbody>";
                    echo '
                            <tr>
                                <td>Invoice No</td>
                                <td>'.$modelInvoiceDetails[0]->invoice_no.'</td>
                            </tr>
                            <tr>
                                <td>Order No</td>
                                <td>'.$modelInvoiceDetails[0]->orders['order_no'].'</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>'.$modelInvoiceDetails[0]->orders['created_at'].'</td>
                            </tr>
                            <tr>
                                <td>payment Date</td>
                                <td>'.$modelInvoiceDetails[0]->payment_date.'</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>'.$modelInvoiceDetails[0]->orders['status'].'</td>
                            </tr>
                        ';
                echo"</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>User Information</b></p><hr>
                            <tbody>";
                echo '
                        <tr>
                            <td>Name</td>
                            <td>'.$modelInvoiceDetails[0]->user['username'].'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$modelInvoiceDetails[0]->user['address'].'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>'.$modelInvoiceDetails[0]->user['email'].'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>'.$modelInvoiceDetails[0]->user['phone'].'</td>
                        </tr>
                    ';
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
                foreach($modelOrders as $modelOrder){
                    echo '
                            <tr>
                                <td>'.$i++.'</td>
                                <td>'.$modelOrder->product->name.'</td>
                                <td>'.$modelOrder->quantity.'</td>
                                <td>'.$modelOrder->total_price.'</td>
                            </tr>
                        ';
                }
                echo "</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6 mt-5">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>Comment</b></p><hr>
                            <tbody>";
                echo '
                        <tr>
                            <td>';

                if ($modelInvoiceDetails[0]->comment == '') {
                    echo 'No Comment Yet';
                } else {
                    echo $modelInvoiceDetails[0]->comment;
                }

                echo '</td>
                        </tr>
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6 mt-5">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>Invoice Total</b></p><hr>
                            <tbody>";
                echo '
                        <tr>
                            <td>Total Price</td>
                            <td>'.$modelInvoiceDetails[0]->orders['total_price'].'</td>
                        </tr>
                        <tr>
                            <td>Total Paid</td>
                            <td>'.$modelInvoiceTotal.'</td>
                        </tr>
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
        </div>
    </div>


</div>
