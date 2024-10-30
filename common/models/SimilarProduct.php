<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "similar_product".
 *
 * @property int $product_id
 * @property int $similar_product_id
 *
 * @property Product $similarProduct
 */
class SimilarProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'similar_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'similar_product_id'], 'required'],
            [['product_id', 'similar_product_id'], 'integer'],
            [['product_id', 'similar_product_id'], 'unique', 'targetAttribute' => ['product_id', 'similar_product_id']],
            [['similar_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['similar_product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'similar_product_id' => Yii::t('app', 'Similar Product ID'),
        ];
    }

    /**
     * Gets query for [[SimilarProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'similar_product_id']);
    }
}
