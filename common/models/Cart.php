<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CartItem[] $cartItems
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }
    public function behaviors(){

        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],

                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
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
    public function clearCart(){
        CartItem::updateAll(['cart_id'=>$this->id],['cart_id'=>null]);
    }

    public static function getUserCart(){
        if (!Yii::$app->user->isGuest){
            $user_id = Yii::$app->user->identity->id;
            $cart=Cart::find()->where(['user_id'=>$user_id])->one();
            if ($cart){
                return $cart;
            }
            else{
                $cart=new Cart();
                $cart->user_id=$user_id;
                $cart->status='active';
                $cart->save();
                return $cart;
            }
        }
        else{

            $session = Yii::$app->session;
            if ($session->has('cart_id')){
                $cart_id=$session->get('cart_id');
                $cart=Cart::find()->where(['id'=>$cart_id])->one();
                if ($cart){

                    return $cart;
                }
            }
            $cart=new Cart();
            $cart->save();
            $session->set('cart_id',$cart->id);
            return $cart;
        }
    }

    public static function totalAmount()
    {
        $cart=Cart::getUserCart();
        $data= CartItem::findall(['cart_id'=>$cart->id]);
        $total=0;
        foreach ($data as $item){
            $total  +=$item->quantity*$item->price;
        }
        return $total;
    }

}
