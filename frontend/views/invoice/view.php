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
        <?= Html::a('Print', ['print', 'id' => $modelInvoiceDetails[0]->invoice_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Download', ['download', 'id' => $modelInvoiceDetails[0]->invoice_id], ['class' => 'btn btn-success']) ?>
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
                                    <td>Unit Price</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                </tr>
                            </thead>
                            <tbody>";
                foreach($modelOrdersDetails as $modelOrdersDetail){
                    echo '
                            <tr>
                                <td>'.$i++.'</td>
                                <td>'.$modelOrdersDetail->product->name.'</td>
                                <td>'.$modelOrdersDetail->product->price.'<span class="money-sign"> &#2547</span></td>
                                <td>'.$modelOrdersDetail->quantity.'</td>
                                <td>'.$modelOrdersDetail->total_price.'<span class="money-sign"> &#2547</span></td>
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
                            <td>'.$modelInvoiceDetails[0]->comment.'</td>
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
                $total_due = $modelOrders[0]->total_price - $modelOrders[0]->total_paid;
                echo '
                        <tr>
                            <td>Total Price</td>
                            <td>'.$modelOrders[0]->total_price.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                        <tr>
                            <td>Paid Amount</td>
                            <td>'.$modelInvoiceDetails[0]->paid_amount.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                        <tr>
                            <td>Total Paid</td>
                            <td>'.$modelOrders[0]->total_paid.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                        <tr>
                            <td>Total Due</td>
                            <td>'.$total_due.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
        </div>
    </div>


</div>
