<?php

use dixonstarter\pdfprint\Pdfprint;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */

$this->title = 'View Orders';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #pdf, #pdf * {
            visibility: visible;
        }
        #pdf {
            margin: 30px;
        }

        table {
            /*border: 1px solid black;*/
            border-collapse: collapse;
            padding: 5px;
            /*text-align:center;*/
        }
    }

</style>

<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type=='admin'){
            echo Html::a('Payment', ['invoice/create', 'id' => $model->order_id], ['class' => 'btn btn-primary mx-1']);
            echo Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-warning mx-1']);
            echo Html::a('Delete', ['delete', 'id' => $model->order_id], [
                'class' => 'btn btn-danger mx-1',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }

        if (!Yii::$app->user->isGuest){
            ?><button class="btn btn-info mx-1" onclick="window.print()">Print</button><?php
            echo Html::a('Download', ['download', 'id' => $model->order_id], ['class' => 'btn btn-success mx-1']);
        }
        ?>

    </p>

    <div class="container" id="pdf">
        <div class="row">
            <div class="col-6">
                <?php
                echo "<table class='table table-striped table-light'>
                            <p><b>Order Information</b></p><hr>
                            <tbody>";
                echo '
                            <tr>
                                <td>Order No</td>
                                <td id="pdf_name">'.$model ->order_no.'</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>'.$model->created_at.'</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>'.$model->status.'</td>
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
                            <td>'.$model->user['username'].'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$model->user['address'].'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>'.$model->user['email'].'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>'.$model->user['phone'].'</td>
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
            <p><b>Order Items</b></p><hr>
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>";
                foreach($modelsOrdersDetails as $modelOrdersDetails){
                    echo '
                <tr>
                    <td>'.$i++.'</td>
                    <td>'.$modelOrdersDetails->product->name.'</td>
                    <td>'.$modelOrdersDetails->product->price.'<span class="money-sign"> &#2547</span></td>
                    <td>'.$modelOrdersDetails->quantity.'</td>
                    <td>'.$modelOrdersDetails->total_price.'<span class="money-sign"> &#2547</span></td>
                </tr>
            ';
                }
                echo "</tbody>
        </table>";
                ?>
            </div>
            <div class="col-6 mt-5"></div>
            <div class="col-6 mt-5">
                <?php
                echo "<table class='table table-striped table-light'>
                            <tbody>";
                $total_due = $model->total_price-$model->total_paid;
                echo '
                        <tr>
                            <th>Total Price</th>
                            <td>'.$model->total_price.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                        <tr>
                            <th>Total Paid</th>
                            <td>'.$model->total_paid.'<span class="money-sign"> &#2547</span></td>
                        </tr>
                        <tr>
                            <th>Total Due</th>
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


<script>
    /*const doc = new jsPDF({
        orientation: "p", //set orientation
        unit: "px", //set unit for document
        format: "A4" //set document standard
    });

    pdf_name = document.getElementById("pdf_name").innerHTML;

    function saveDiv(divId, title) {
        doc.fromHTML(document.getElementById(divId).innerHTML);
        doc.save(pdf_name+'.pdf');
    }

    function printDiv(divId,
                      title) {

        let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

        mywindow.document.write(`<html><head><title>${title}</title>`);
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(divId).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*!/

        mywindow.print();
        mywindow.close();

        return true;
    }*/

</script>
