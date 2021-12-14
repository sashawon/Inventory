<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "orders_details".
 *
 * @property int $orders_details_id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property int|null $total_price
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class OrdersDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'total_price'], 'integer'],
            [['product_id', 'total_price'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orders_details_id' => 'Orders Details ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product Name',
            'quantity' => 'Quantity',
            'total_price' => 'Total Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['order_id' => 'order_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }
}
