<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

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
                                <td>'.$form->field($model, 'invoice_no')->textInput(['value' => $invoice_no, 'readonly'=> true])->label(false).'</td>
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
                                <td>'.$form->field($model, 'payment_date')->widget(DatePicker::className(),['clientOptions' => ['dateFormat' => 'yy-mm-dd']])->textInput(['placeholder' => \Yii::t('app', 'mm/dd/yyyy'), 'class' => 'form-control'])->label(false).'</td>
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
                        <tr class="bg-light">
                            <td class="p-0">'. $form->field($model, 'comment')->textarea(['rows' => 6])->label(false) .'</td>
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
                        <tr>
                            <td>Due</td>
                            <td>';
                                echo $modelInvoiceDetails[0]->orders['total_price'] - $modelInvoiceTotal;
                            echo '</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>'.$form->field($model, 'paid_amount')->textInput()->label(false).'</td>
                        </tr>
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
        </div>
    </div>


    <?= $form->field($model, 'order_id')->hiddenInput(['value' => $modelInvoiceDetails[0]->orders['order_id']])->label(false) ?>

    <?= $form->field($model, 'customer_id')->hiddenInput(['value' => $modelInvoiceDetails[0]->orders['user_id']])->label(false) ?>


    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date("F j, Y, g:i a")])->label(false) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
