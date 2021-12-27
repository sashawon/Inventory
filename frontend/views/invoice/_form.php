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

                $due = $modelOrders[0]->total_price - $modelOrders[0]->total_paid;

                echo "<table class='table table-striped table-light'>
                            <p><b>Order Information</b></p><hr>
                            <tbody>";
                echo '
                            <tr>
                                <td>Name</td>
                                <td>'.$modelOrders[0]->user['username'].'</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>'.$modelOrders[0]->user['phone'].'</td>
                            </tr>
                            <tr>
                                <td>Order No</td>
                                <td>'.$modelOrders[0]->order_no.'</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>'.$modelOrders[0]->created_at.'</td>
                            </tr>
                            <tr class="bg-light">
                                <td>Comment</td>
                                <td>'. $form->field($model, 'comment')->textarea(['rows' => 3])->label(false) .'</td>
                            </tr>
                        ';
                echo"</tbody>
                        </table>";
                ?>
            </div>
            <div class="col-6">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>Payment Details</b></p><hr>
                            <tbody>";
                echo '
                        
                        <tr>
                            <td>payment Date</td>
                            <td>'.$form->field($model, 'payment_date')->widget(DatePicker::className(),['clientOptions' => ['dateFormat' => 'yy-mm-dd']])->textInput(['placeholder' => \Yii::t('app', 'mm/dd/yyyy'), 'class' => 'form-control'])->label(false).'</td>
                        </tr>
                        <tr>
                            <td>Total Price</td>
                            <td>'.$modelOrders[0]->total_price.'</td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td class="due">'.$due.'</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>'.$form->field($model, 'paid_amount')->textInput(['type'=>'number', 'class' => 'form-control paid-amount'])->label(false).'</td>
                        </tr>                        
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
        </div>
    </div>


    <?= $form->field($model, 'invoice_no')->hiddenInput(['value' => $invoice_no, 'readonly'=> true])->label(false) ?>

    <?= $form->field($model, 'order_id')->hiddenInput(['value' => $modelOrders[0]->order_id])->label(false) ?>

    <?= $form->field($model, 'customer_id')->hiddenInput(['value' => $modelOrders[0]->user_id])->label(false) ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date("F j, Y, g:i a")])->label(false) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).delegate('.paid-amount','change',function(){
        check_amount();
    });

    function check_amount(){
        paid_amount = $('.paid-amount').val();
        var paid_amount_float = parseFloat(paid_amount);
        total_due = $('.due').html();
        var total_due_float = parseFloat(total_due);
        /*console.log(paid_amount_float);
        console.log(total_due_float);*/

        if (paid_amount_float>0) {
            if (paid_amount_float > total_due_float) {
                $('.paid-amount').val(0);
            }
        } else {
            $('.paid-amount').val(0);
        }
    }
</script>
