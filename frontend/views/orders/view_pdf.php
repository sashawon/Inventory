<!DOCTYPE html>
<html>
<head>
    <title>Download</title>

    <style>
        .orders-download-view{
            position: relative;
            margin: 15px;
        }

        .table-col-1{
            position: absolute;
            top: 0;
            left: 0;
            width: 40%;
            margin: 10px;
        }

        .table-col-2{
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            margin: 10px;
        }

        .table-col-3{
            position: absolute;
            top: 200px;
            right: 0;
            width: 100%;
        }

        .table-col-4{
            position: absolute;
            top: 500px;
            right: 0;
            width: 50%;
        }

        .table-1, .table-2, .table-3, .table-4{
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            /*text-align:center;*/
        }

    </style>

</head>
<body>

<div class="orders-download-view">
    <div class="container">
        <div class="row">
            <div class="table-col-1">
                <?=
                '<table class="table-1 table-striped table-light">
                            <tbody>
                            <tr>
                                <td>Order No</td>
                                <td>'.$model ->order_no.'</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>'.$model->created_at.'</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>'.$model->status.'</td>
                            </tr>
                        </tbody>
                    </table>';
                ?>
            </div>
            <div class="table-col-2">
                <?=
                '<table class="table-2 table-striped table-light">
                        <tbody>
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
                        </tbody>
                    </table>';
                ?>
            </div>
            <div class="table-col-3">
                <?php
                $i = 1;
                echo "<table class='table-3 table-striped table-light'>
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
                echo '</tbody>
        </table>';
                ?>
            </div>
            <div class="table-col-4">
                <?php
                echo "<table class='table-4 table-striped table-light'>
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
                            <td>'.$total_due.'<span class="money-sign"> ৳</span></td>
                        </tr>
                    ';
                echo "</tbody>
                        </table>";
                ?>
            </div>
        </div>
    </div>

</div>

</body>
</html>




