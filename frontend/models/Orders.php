<?php

namespace frontend\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property string|null $order_no
 * @property int|null $user_id
 * @property int|null $total_price
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Orders extends \yii\db\ActiveRecord
{
    
    // public $user_id = $_SESSION['__id'];
    // $session = Yii::$app->session;
    // private static $users = $session["__id"];
    // public $user_id = 0;
    // $session = Yii::app()->session->getSessionID();

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'total_price'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_no', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_no' => 'Order No',
            'user_id' => 'User ID',
            'total_price' => 'Total Price',
            'status' => 'Status',
        ];
    }

    public function getOrdersDetails()
    {
        return $this->hasMany(OrdersDetails::class, ['order_id' => 'order_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getInvoice()
    {
        return $this->hasMany(Invoice::class, ['order_id' => 'order_id']);
    }
}
