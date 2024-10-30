<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "related_product".
 *
 * @property int $product_id
 * @property int $related_product_id
 *
 * @property Product $relatedProduct
 */
class RelatedProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'related_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'related_product_id'], 'required'],
            [['product_id', 'related_product_id'], 'integer'],
            [['product_id', 'related_product_id'], 'unique', 'targetAttribute' => ['product_id', 'related_product_id']],
            [['related_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['related_product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'related_product_id' => Yii::t('app', 'Related Product ID'),
        ];
    }

    /**
     * Gets query for [[RelatedProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'related_product_id']);
    }
}
