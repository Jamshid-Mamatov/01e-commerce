<?php

namespace common\models;

use common\components\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_active
 * @property float|null $price
 * @property int|null $is_discount
 * @property float|null $discount_price
 * @property int|null $stock
 * @property string|null $description
 * @property int|null $category_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 * @property ProductAttributeValue[] $productAttributeValues
 * @property ProductImages[] $productImages
 * @property ProductTranslation[] $productTranslations
 * @property Product[] $products
 * @property Product[] $products0
 * @property RecentlyViewedProduct[] $recentlyViewedProducts
 * @property RelatedProduct[] $relatedProducts
 * @property RelatedProduct[] $relatedProducts0
 * @property Product[] $relatedProducts1
 * @property Review[] $reviews
 * @property SimilarProduct[] $similarProducts
 * @property SimilarProduct[] $similarProducts0
 * @property Product[] $similarProducts1
 * @property User[] $users
 * @property Wishlist[] $wishlists
 */
class Product extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $similar_product_ids=[];
    public $related_product_ids=[];

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
            [['similar_product_ids','related_product_ids'], 'safe'],
            [['price'],'required'],
            [['stock', 'category_id'], 'integer'],
            [['is_active', 'is_discount'],'boolean'],
            [['price', 'discount_price'], 'number'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'is_active' => Yii::t('app', 'Is Active'),
            'price' => Yii::t('app', 'Price'),
            'is_discount' => Yii::t('app', 'Is Discount'),
            'discount_price' => Yii::t('app', 'Discount Price'),
            'stock' => Yii::t('app', 'Stock'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductAttributeValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTranslations()
    {
        return $this->hasMany(ProductTranslation::class, ['product_id' => 'id']);
    }
    public function getTranslatedAttributes(){

        $languageCode = Yii::$app->language;
        $translation= $this->getProductTranslations()->where(['language_code'=>$languageCode])->one();

        if ($translation){
            return [
                'title' => $translation->title,
                'description' => $translation->description,
            ];
        }

        return [
            'title' => $this->name,
            'description' => $this->description,
        ];
    }



    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('related_product', ['related_product_id' => 'id']);
    }

    /**
     * Gets query for [[Products0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('similar_product', ['similar_product_id' => 'id']);
    }

    /**
     * Gets query for [[RecentlyViewedProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecentlyViewedProducts()
    {
        return $this->hasMany(RecentlyViewedProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[RelatedProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProducts()
    {
        return $this->hasMany(RelatedProduct::class, ['product_id' => 'id'])->via('relatedProduct');
    }

    /**
     * Gets query for [[RelatedProducts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProducts0()
    {
        return $this->hasMany(RelatedProduct::class, ['related_product_id' => 'id']);
    }

    /**
     * Gets query for [[RelatedProducts1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProducts1()
    {
        return $this->hasMany(Product::class, ['id' => 'related_product_id'])->viaTable('related_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[SimilarProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarProducts()
    {
        return $this->hasMany(SimilarProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[SimilarProducts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarProducts0()
    {
        return $this->hasMany(SimilarProduct::class, ['similar_product_id' => 'id']);
    }

    /**
     * Gets query for [[SimilarProducts1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarProducts1()
    {
        return $this->hasMany(Product::class, ['id' => 'similar_product_id'])->viaTable('similar_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('recently_viewed_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['product_id' => 'id']);
    }
    public function upload($images){
        $order=1;
        $not_upload=[];
        $uploaded = [];

        foreach ($images as $image) {

            $path=Utils::uploadImage($image);
            if ($path){
                $imagemodel= new ProductImages(['product_id' => $this->id,'image_path'=>$path,'order'=>$order]);
                $imagemodel->save();
                $uploaded[]=$imagemodel->id;
                $order++;
            }
            else{
                $not_upload[]=$image;
            }

        }

        return [$not_upload, $uploaded];
    }

    public function getAdvertisement(){
        return $this->hasMany(Advertisement::class, ['id' => 'advertisement_id'])->viaTable('advertisement_products', ['product_id' => 'id']);
    }
}
