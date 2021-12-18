<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $invoice_id
 * @property string|null $invoice_no
 * @property int|null $order_id
 * @property int|null $customer_id
 * @property int|null $paid_amount
 * @property string|null $comment
 * @property string|null $payment_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'customer_id'], 'integer'],
            [['paid_amount'], 'integer', 'min' => 0],
            [['paid_amount', 'payment_date'], 'required'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['invoice_no'], 'string', 'max' => 255],
            [['payment_date'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'invoice_no' => 'Invoice No',
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
            'paid_amount' => 'Paid Amount',
            'comment' => 'Comment',
            'payment_date' => 'Payment Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['order_id' => 'order_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'customer_id']);
    }
}
