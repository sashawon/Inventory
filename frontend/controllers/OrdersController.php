<?php

namespace frontend\controllers;

use frontend\models\Orders;
use frontend\models\OrdersSearch;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use frontend\models\OrdersDetails;
use frontend\models\Invoice;
use frontend\models\Product;
use frontend\models\Model;
use yii\web\Response;
use yii\helpers\Url;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProductinfo($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // echo $id; die();
        $countItem = Product::find()
                    ->where(['product_id' => $id])
                    ->count();

        $Items = Product::find()
                    ->where(['product_id' => $id])
                    ->asArray()
                    ->one();

        if ($countItem > 0) {
            return $Items;
        } else {
            return NULL;
        }

    }

    public function actionProductpricecount($id, $quantity, $product_quantity, $product_total_price)
    {
        // echo $quantity.$product_quantity.$product_total_price; die();
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id!=NULL && $product_quantity!=NULL) {
            if ($quantity>0) {
                 $currentItem = Product::find()->where(['product_id' => $id])->one();
                 if ($currentItem->quantity>0) {
                    if ($currentItem->quantity>=$quantity) {
                        $currentItemTotalPrice = $currentItem->price*$quantity;

                        $totalPriceInfo = [
                            'currentItemTotalPrice' => $currentItemTotalPrice,
                        ];
                        return $totalPriceInfo;

                    } else {

                        $qty = $currentItem->quantity;
                        $selectData = "Selected Product quantity Should be Less than or Equal to Product Quantity!";

                        $result = [
                                'qty' => $qty,
                                'selectData' => $selectData,
                            ];
                        return $result;
                    }

                 } else {

                    $qty = 0;
                    $selectData = "Selected Product Not Available!";

                    $result = [
                            'qty' => $qty,
                            'selectData' => $selectData,
                        ];
                    return $result;
                 }
                 
            } else {

                $qty = 0;
                $selectData = "Select Product More Than 0!";

                $result = [
                        'qty' => $qty,
                        'selectData' => $selectData,
                    ];

                return $result;
            }
            
        } else {
            $qty = 0;
            $selectData = "Select Product First!";

            $result = [
                    'qty' => $qty,
                    'selectData' => $selectData,
                ];

            return $result;
        }

    }

    public function actionView($id)
    {
        $modelsOrdersDetails = OrdersDetails::find()
                                ->joinWith('product')
                                ->where(['order_id' => $id])
                                ->all();

        // $modelsProduct = Product::find()
        //                 ->all();

        // echo"<pre>"; print_r($modelsOrdersDetails); die();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelsOrdersDetails' => $modelsOrdersDetails,
            // 'modelsProduct' => $modelsProduct,
        ]);
    }

    public function actionCreate()
    {
        $model = new Orders();
        $modelsOrdersDetails = [new OrdersDetails];
        $modelsInvoice = new Invoice();

        $userInfo = Yii::$app->user->identity;
        $order_no = rand(11111111111, 99999999999).date("dmy");
        $url = Url::toRoute('orders/productinfo');
        $urlproductpricecount = Url::toRoute('orders/productpricecount');
        // echo"<pre>"; print_r($userInfo); die();

        if ($this->request->isPost) {
            // echo"<pre>"; var_dump($this->request->post()); die();
            if ($model->load($this->request->post()) && $model->save()) {

                $modelsInvoiceOrderId =  $modelsInvoice->order_id = $model->order_id;
                $modelsInvoice->invoice_no = rand(11111111111, 99999999999).date("dmy");
                $modelsInvoice->customer_id = $model->user_id;
                $modelsInvoice->paid_amount = '0';
                $modelsInvoice->comment = 'No Comment';
                $modelsInvoice->payment_date = date("F j, Y, g:i a");
                $modelsInvoice->created_at = date("F j, Y, g:i a");
//                $modelsInvoice->load($this->request->post());
                $modelsInvoice->save(false);
//                echo"<pre>"; var_dump($modelsInvoice); die();


                $modelsOrdersDetails = Model::createMultiple(OrdersDetails::classname());
                Model::loadMultiple($modelsOrdersDetails, Yii::$app->request->post());

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsOrdersDetails) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsOrdersDetails as $modelOrdersDetails) {
                                $modelOrdersDetails->order_id = $model->order_id;
                                if (! ($flag = $modelOrdersDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();

                            foreach ($this->request->post()["OrdersDetails"] as $OrderDetail){
                                $product_id = $OrderDetail["product_id"];
                                $order_quantity = $OrderDetail["quantity"];
                                $product_quantity = Product::find()->where(['product_id' => $product_id])->one();
                                $current_quantity = $product_quantity->quantity - $order_quantity;

                                // update an existing product quantity
                                $product = Product::findOne($product_id);
                                $product->quantity = $current_quantity;
                                $product->save();
                            }

                            $currentInvoice = Invoice::find()->where(['order_id' => $modelsInvoiceOrderId])->orderBy(['invoice_id' => SORT_DESC])->one();

//                            echo "<pre>";
//                            var_dump($currentInvoice);
//                            die();

                            return $this->redirect(['invoice/view', 'id' => $currentInvoice->invoice_id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                // return $this->redirect(['view', 'id' => $model->order_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'userInfo' => $userInfo,
            'order_no' => $order_no,
            'url' => $url,
            'urlproductpricecount' => $urlproductpricecount,
            'modelsInvoice' => $modelsInvoice,
            'modelsOrdersDetails' => (empty($modelsOrdersDetails)) ? [new OrdersDetails] : $modelsOrdersDetails,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsOrdersDetails = OrdersDetails::find()->where(['order_id' => $id])->all();
        $modelsInvoice = new Invoice();

        $modelInvoiceTotal = Invoice::find()
                            ->where(['order_id' => $id])
                            ->sum('paid_amount');

        if ($modelInvoiceTotal>0) {
            Yii::$app->session->setFlash('error', "Not able to update this order, Because payment has done!");
            return $this->redirect(Url::toRoute('orders/index'));
        } else {
            $userInfo = Yii::$app->user->identity;
            $order_no = $model->order_no;
            $url = Url::toRoute('orders/productinfo');
            $urlproductpricecount = Url::toRoute('orders/productpricecount');
            // echo"<pre>"; print_r($modelsOrdersDetails); die();

            if ($model->load(Yii::$app->request->post())) {

                $modelsInvoiceOrderId =  $modelsInvoice->order_id = $model->order_id;
                $modelsInvoice->invoice_no = rand(11111111111, 99999999999).date("dmy");
                $modelsInvoice->customer_id = $model->user_id;
                $modelsInvoice->paid_amount = '0';
                $modelsInvoice->comment = 'No Comment';
                $modelsInvoice->payment_date = date("F j, Y, g:i a");
                $modelsInvoice->created_at = date("F j, Y, g:i a");
//                $modelsInvoice->load($this->request->post());
                $modelsInvoice->save(false);
//                echo"<pre>"; var_dump($modelsInvoice); die();

                $oldIDs = ArrayHelper::map($modelsOrdersDetails, 'orders_details_id', 'orders_details_id');
                $modelsOrdersDetails = Model::createMultiple(OrdersDetails::classname(), $modelsOrdersDetails);
                Model::loadMultiple($modelsOrdersDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOrdersDetails, 'orders_details_id', 'orders_details_id')));

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsOrdersDetails) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                OrdersDetails::deleteAll(['orders_details_id' => $deletedIDs]);
                            }
                            foreach ($modelsOrdersDetails as $modelOrdersDetails) {
                                $modelOrdersDetails->order_id = $model->order_id;
                                if (! ($flag = $modelOrdersDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();

                            $currentInvoice = Invoice::find()->where(['order_id' => $modelsInvoiceOrderId])->orderBy(['invoice_id' => SORT_DESC])->one();
                            return $this->redirect(['invoice/view', 'id' => $currentInvoice->invoice_id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }

            return $this->render('update', [
                'model' => $model,
                'userInfo' => $userInfo,
                'order_no' => $order_no,
                'url' => $url,
                'urlproductpricecount' => $urlproductpricecount,
                'modelsOrdersDetails' => (empty($modelsOrdersDetails)) ? [new OrdersDetails] : $modelsOrdersDetails
            ]);
        }

    }

    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        // $modelsOrdersDetails = OrdersDetails::deleteAll(['order_id' => $id]);

        $model = $this->findModel($id);
        $modelsOrdersDetails = OrdersDetails::find()->where(['order_id' => $id])->all();
        // echo"<pre>"; print_r($modelsOrdersDetails[0]); die();


        $oldIDs = ArrayHelper::map($modelsOrdersDetails, 'orders_details_id', 'orders_details_id');
        if (!empty($oldIDs)) {
            OrdersDetails::deleteAll(['orders_details_id' => $oldIDs]);
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Record deleted successfully.');
        }

        return $this->redirect(['index']);
    }

    public function actionOrder_info($id='')
    {
        
        $model = Orders::find()
                // ->joinWith('product')
                ->where(['user_id' => $id])
                ->all();

        $userInfo = Yii::$app->user->identity;

        return $this->render('order_info', [
            'model' => $model,
            'userInfo' => $userInfo,
        ]);

    }

    public function actionOrder_items_details($id)
    {
        
        $model = Orders::find()
                ->joinWith('user')
                ->where(['order_id' => $id])
                ->all();

        $modelsOrdersDetails = OrdersDetails::find()
                                ->joinWith('product')
                                ->where(['order_id' => $id])
                                ->all();

        // echo"<pre>"; print_r($modelsOrdersDetails); die();

        return $this->render('order_items_details', [
            'model' => $model,
            'modelsOrdersDetails' => $modelsOrdersDetails,
        ]);

        /*$model = $this->findModel($id);
        // $modelsOrdersDetails = OrdersDetails::find()->where(['order_id' => $id])->all();
        // $userInfo = Yii::$app->user->identity;
        // $order_no = $model->order_no;

        $modelsOrdersDetails = OrdersDetails::find()
                                ->joinWith('product')
                                ->where(['order_id' => $id])
                                ->all();

        // $modelsProduct = Product::find()
        //                 ->all();

        // echo"<pre>"; print_r($modelsOrdersDetails); die();

        return $this->render('view', [
            // 'model' => $model,
            'modelsOrdersDetails' => $modelsOrdersDetails,
            // 'modelsProduct' => $modelsProduct,
        ]);

        // echo "<pre>";
        // var_dump($model);
        // die();

        return $this->render('invoice', [
            'model' => $model,
            'modelsOrdersDetails' => $modelsOrdersDetails,
        ]);

        return $this->render('invoice');*/
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
