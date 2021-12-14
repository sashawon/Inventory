<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property string|null $name
 * @property string|null $photo
 * @property int|null $price
 * @property int|null $quantity
 * @property string|null $details
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'quantity', 'status'], 'integer'],
            [['details'], 'string'],
            // [['created_at', 'updated_at'], 'safe'],
            ['name','required'],
            ['price','required'],
            ['quantity','required'],
            [['name'], 'string', 'max' => 255],
            // [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    // public function upload()
    // {
    //     if ($this->validate()) {
    //         $this->photo->saveAs('uploads/' . $this->photo->baseName . '.' . $this->photo->extension);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'name' => 'Name',
            'photo' => 'Photo',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'details' => 'Details',
            'status' => 'Status',
            'created_at' => 'Created At',
            // date('Y-m-d H:i:s')
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrdersDetails()
    {
        return $this->hasOne(OrdersDetails::className(), ['product_id' => 'product_id']);
    }
}
