<?php

namespace frontend\controllers;

use frontend\models\Invoice;
use frontend\models\InvoiceSearch;
use frontend\models\OrdersDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use frontend\models\Orders;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        $model = $this->findModel($id);

        $modelInvoiceDetails = Invoice::findAll(['invoice_id' => $id]);

        $InvoiceOrderId = $modelInvoiceDetails[0]['order_id'];

        $modelOrders = Orders::findAll(['order_id' => $InvoiceOrderId]);

        $modelOrdersDetails = OrdersDetails::find()
            ->with('orders', 'product')
            ->where(['order_id' => $InvoiceOrderId])
            ->all();

        return $this->render('view', [
            'modelInvoiceDetails' => $modelInvoiceDetails,
            'modelOrders' => $modelOrders,
            'modelOrdersDetails' => $modelOrdersDetails,
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Invoice();

        $modelOrders = Orders::findAll(['order_id' => $id]);

        $invoice_no = rand(11111111111, 99999999999).date("dmy");

        /*$modelOrders = OrdersDetails::find()
            ->with('orders', 'product')
            ->where(['order_id' => $id])
            ->all();*/

        if ($this->request->isPost) {
            if ($this->request->post()['Invoice']['comment'] == ''){
                $loadData = $model->load($this->request->post());
                $model->comment = 'No comment';
            } else {
                $loadData = $model->load($this->request->post());
            }

            if ($loadData && $model->save()) {
                $modelInvoiceTotal = Invoice::find()
                                    ->where(['order_id' => $id])
                                    ->sum('paid_amount');

                $modelOrdersTotal = Orders::find()
                                    ->where(['order_id' => $id])
                                    ->one();

                $modelOrdersTotal->total_paid = $modelInvoiceTotal;
                $modelOrdersTotal->save();

                $due = $modelOrdersTotal->total_price - $modelOrdersTotal->total_paid;

                if ($due == 0) {
                    $modelOrdersStatus = Orders::find()
                        ->where(['order_id' => $id])
                        ->one();
                    $modelOrdersStatus->status = 'Paid';
                    $modelOrdersStatus->save();
                }

                return $this->redirect(['view', 'id' => $model->invoice_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'modelOrders' => $modelOrders,
            'invoice_no' => $invoice_no,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->invoice_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
