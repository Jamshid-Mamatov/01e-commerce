<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $status
 * @property float|null $total_amount
 * @property string|null $payment_status
 * @property string|null $delivery_type
 * @property string|null $payment_type
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CartItem[] $cartItems
 * @property User $user
 */
class Order extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['total_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['total_amount'], 'required'],
            [['total_amount'], 'number', 'min' => 0.01],
            [['status', 'payment_status', 'delivery_type', 'payment_type','first_name','last_name','phone','email','country','city','address','comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'delivery_type' => Yii::t('app', 'Delivery Method'),
            'payment_type' => Yii::t('app', 'Payment Method'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'country' => Yii::t('app', 'Country'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'comment' => Yii::t('app', 'Comment'),

        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
