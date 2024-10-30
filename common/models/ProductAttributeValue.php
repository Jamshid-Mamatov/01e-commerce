<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_attribute_value".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $attribute_id
 * @property string|null $value
 *
 * @property Attribute $attribute0
 * @property Product $product
 */
class ProductAttributeValue extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_attribute_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'attribute_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::class, 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * Gets query for [[Attribute0]].
     *
     * @param $name
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(Attribute::class, ['id' => 'attribute_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
