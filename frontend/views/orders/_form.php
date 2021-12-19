<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\Product;
use common\models\User;
use yii\helpers\Url;

use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});
';

$this->registerJs($js);

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-12"><p><b>Order Information</b></p></div>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <td>Order No: </td>
                <td>
                    <?php $paid_status='Unpaid'; ?>
                    <?= $form->field($model, 'order_no')->textInput(['value'=>$order_no, 'readonly'=> true])->label(false) ?>
                    <?= $form->field($model, 'status')->hiddenInput(['value'=>$paid_status, 'class' => 'form-control order_paid_status', 'readonly'=> true])->label(false) ?>
                    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date("F j, Y, g:i a")])->label(false) ?>
                </td>
                    <?php if (!Yii::$app->user->isGuest && $userInfo->user_type=='customer') {?>
                <td>User Name: </td>
                <td>
                    <input type="text" id="orders-username" class="form-control" value="<?=$userInfo->username?>" readonly>
                    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$userInfo->user_id, 'class' => 'form-control orders-user_id', 'readonly'=> true])->label(false) ?>
                </td>
            </tr>
            <tr>
                <td>Address</td>
                <td>
                    <input type="text" id="orders-address" class="form-control"value="<?=$userInfo->address?>" readonly>
                    <?php } ?>
                </td>
                <?php if (!Yii::$app->user->isGuest && $userInfo->user_type=='admin') {?>
                <td>User Name: </td>
                <td>
                    <!-- User list for admin panel -->
                    <?= $form->field($model, "user_id")->dropdownList(
                                ArrayHelper::map(User::find()->where(['status' => 10])->all(),'user_id','username'),
                                [
                                    'prompt'=>'Select Item',
                                    'class' => 'form-control orders-user_id'
                                ]
                            )->label(false);
                        ?>
                </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
    

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsOrdersDetails[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'product_id',
            'quantity',
            'total_price',
        ],
    ]); ?>

    <div class="panel">
        <p><b>Order Items</b></p> 
        <hr>
        <div class="text-right">
            <button type="button" class="add-item btn btn-success btn-sm"><i class="fas fa-plus"></i> Add Item</button>
        </div>
        <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                <?php foreach ($modelsOrdersDetails as $i => $modelOrdersDetails): ?>
                    <tr class="p_row item panel panel-default">
                        <?php
                            // necessary for update action.
                            if (! $modelOrdersDetails->isNewRecord) {
                                echo Html::activeHiddenInput($modelOrdersDetails, "[{$i}]orders_details_id");
                            }
                        ?>  
                        <td>
                            <?= $form->field($modelOrdersDetails, "[{$i}]product_id")->dropdownList(
                                ArrayHelper::map(Product::find()->all(),'product_id','name'),
                                [
                                    'prompt' => 'Select Item',
                                    'class' => 'form-control product_id',
                                ]
                            )->label(false);
                            ?>
                        </td>
                        <td>
                            <div class="form-group field-ordersdetails-0-quantity">
                            <?php
                                if (! $modelOrdersDetails->isNewRecord) {
                                    $orders_details_product_id = $modelOrdersDetails->product_id;
                                    $orders_details_product = Product::find()->where(['product_id' => $orders_details_product_id])->all();
                                    echo '<input type="text" id="ordersdetails-0-quantity product-quantity" class="form-control ordersdetails-0-quantity product-quantity" readonly value="'.$orders_details_product[0]->quantity.'">';
                                } else {
                                    echo '<input type="text" id="ordersdetails-0-quantity product-quantity" class="form-control ordersdetails-0-quantity product-quantity" readonly value="0">';
                                }
                            ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-ordersdetails-0-price">
                            <?php
                                if (! $modelOrdersDetails->isNewRecord) {
                                    $orders_details_product_id = $modelOrdersDetails->product_id;
                                    $orders_details_product = Product::find()->where(['product_id' => $orders_details_product_id])->all();
                                    echo '<input type="text" id="ordersdetails-0-price product-price" class="form-control ordersdetails-0-price product-price" readonly value="'.$orders_details_product[0]->price.'">';
                                } else {
                                    echo '<input type="text" id="ordersdetails-0-price product-price" class="form-control ordersdetails-0-price product-price" readonly value="0">';
                                }
                            ?>
                            </div>
                        </td>
                        <td>
                            <?php
                                if (! $modelOrdersDetails->isNewRecord) {
                                    echo $form->field($modelOrdersDetails, "[{$i}]quantity")->textInput(['type'=>'number', 'value'=>$modelOrdersDetails->quantity, 'class' => 'form-control quantity'])->label(false);
                                } else {
                                    echo $form->field($modelOrdersDetails, "[{$i}]quantity")->textInput(['type'=>'number', 'value'=>'0', 'class' => 'form-control quantity'])->label(false);
                                }
                            ?>
                            <div class="product_name_error text-danger"></div>
                        </td>
                        <td>
                            <?php
                                if (! $modelOrdersDetails->isNewRecord) {
                                    echo $form->field($modelOrdersDetails, "[{$i}]total_price")->textInput(['type'=>'number', 'value'=>$modelOrdersDetails->total_price, 'class' => 'form-control product_total_price', 'readonly'=> true])->label(false);
                                } else {
                                    echo $form->field($modelOrdersDetails, "[{$i}]total_price")->textInput(['type'=>'number', 'value'=>'0', 'class' => 'form-control product_total_price', 'readonly'=> true])->label(false);
                                }


                                if (! $modelOrdersDetails->isNewRecord) {
                                    echo $form->field($modelOrdersDetails, "[{$i}]created_at")->hiddenInput(['value'=>$modelOrdersDetails->created_at])->label(false);
                                } else {
                                    echo $form->field($modelOrdersDetails, "[{$i}]created_at")->hiddenInput(['value' => date("F j, Y, g:i a")])->label(false);
                                }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="remove-item btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
    </div><!-- .panel -->

    <?php DynamicFormWidget::end(); ?>
    <div class="row justify-content-end">
        <div class="col-sm-4">
            <?php
                // necessary for update action.
                if (! $model->isNewRecord) {
                    echo $form->field($model, 'total_price')->textInput(['maxlength' => true, 'value'=>$model->total_price, 'class' => 'form-control orders-total_price', 'readonly'=> true]);
                } else {
                    echo $form->field($model, 'total_price')->textInput(['maxlength' => true, 'value'=>'0', 'class' => 'form-control orders-total_price', 'readonly'=> true]);
                }
            ?>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton($modelOrdersDetails->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

    $(document).delegate('.add-item','click',function(){
        total();
    });

    $(document).delegate('.remove-item','click',function(){
        total();
    });

    $(document).delegate('.product_id','change',function(){
        product_id = $(this).val(),
        parent = $(this).parents('.p_row').first(),
        // parent.find(":input").val(),
        quantity = parent.find('.product-quantity').first(),
        price = parent.find('.product-price').first(),
        parent.find('.quantity').val(null),
        parent.find('.product_total_price').val(null),

        // console.log(product_id);
        // console.log(quantity);

        $.ajax({
            url: '<?= $url ?>',
            type: 'get',
            data: {id:product_id},
            success: function(response) {
                // console.log(response);
                $(quantity).val(response.quantity);
                $(price).val(response.price);
            },
            error: function() {
                console.log('error');
            }
        });
    });

    $(document).delegate('.quantity','change',function(){
        quantity = $(this).val(),
        product_quantity = $('.product-quantity').val();
        product_total_price = $('.product_total_price').val();
        parent = $(this).parents('.p_row').first(),
        product_id = parent.find('.product_id').val(),
        child_product_total_price = parent.find('.product_total_price').first(),
        child_product_error = parent.find('.product_name_error').first(),
        child_product_quantity_error = parent.find('.quantity').first(),

        $.ajax({
            url: '<?= $urlproductpricecount ?>',
            type: 'get',
            data: {id:product_id,
                    quantity:quantity,
                    product_quantity:product_quantity,
                    product_total_price:product_total_price
                },
            success: function(response) {
                // console.log(response);
                $(child_product_total_price).val(response.currentItemTotalPrice);
                if(response.qty != null ){
                    $(child_product_error).html(response.selectData);
                    $(child_product_quantity_error).val(response.qty);
                } else {
                    $(child_product_error).html('');
                };
                total();
            },
            error: function() {
                console.log('error');
            }
        });
    });

    $(document).delegate('.quantity','blur',function(){
        quantity = $(this).val(),
        product_quantity = $('.product-quantity').val();
        product_total_price = $('.product_total_price').val();
        parent = $(this).parents('.p_row').first(),
        product_id = parent.find('.product_id').val(),
        child_product_total_price = parent.find('.product_total_price').first(),
        child_product_error = parent.find('.product_name_error').first(),
        child_product_quantity_error = parent.find('.quantity').first(),

        $.ajax({
            url: '<?= $urlproductpricecount ?>',
            type: 'get',
            data: {id:product_id,
                    quantity:quantity,
                    product_quantity:product_quantity,
                    product_total_price:product_total_price
                },
            success: function(response) {
                // console.log(response);
                $(child_product_total_price).val(response.currentItemTotalPrice);
                if(response.qty != null ){
                    $(child_product_error).html(response.selectData);
                    $(child_product_quantity_error).val(response.qty);
                } else {
                    $(child_product_error).html('');
                };
                total();
            },
            error: function() {
                console.log('error');
            }
        });
    });

    function total(){
    var totalPrice = 0;
        jQuery(".product_total_price").each(function() {
            var order_total_price = parseInt($(this).val());
            
            if (isNaN(order_total_price)) {
                order_total_price = 0;
            }
            totalPrice += order_total_price;

            $("#orders-total_price").val(totalPrice);
        });
    }


</script>