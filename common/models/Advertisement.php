<?php

namespace common\models;

use common\components\Utils;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "advertisement".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $start_date
 * @property string $end_date
 *
 * @property AdvertisementCategories[] $advertisementCategories
 * @property AdvertisementProducts[] $advertisementProducts
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'start_date', 'end_date'], 'required'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'type'], 'string', 'max' => 255],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>=', 'message' => 'End date must be greater than or equal to start date.'],
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
            'type' => Yii::t('app', 'Type'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }

    /**
     * Gets query for [[AdvertisementCategories]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('advertisement_products', ['advertisement_id' => 'id']);
    }

    public function getCategories()
    {

        return $this->hasmany(Category::class, ['id' => 'category_id'])->viaTable('advertisement_categories', ['advertisement_id' => 'id']);
    }


    public function linkAll($ids, $ad_value,$table=null)
    {
        $rows = [];
        if ($table==null) {
            $table = $this->type == 'category' ? 'advertisement_categories' : 'advertisement_products';
            $columns=[$this->type == "category" ? "category_id" : "product_id", 'advertisement_id'];
        }
        else{
            $columns=["product_id", 'advertisement_id'];
        }


        if ($ids === null || empty($ids)) {
            return;
        }
        foreach ($ids as $id) {
//            Utils::printAsError($table);

            if ($table != "advertisement_categories"){
                $existingAd = (new \yii\db\Query())
                    ->from($table)
                    ->where(['product_id' => $id])
                    ->one();
                if ($existingAd) {
                    if ($existingAd['advertisement_id'] != $this->id) {
                        Yii::$app->db->createCommand()->update($table,
                            ['advertisement_id' => $this->id],
                            ['product_id' => $id] )->execute();
                    }
                }
                else{
                    $rows[] = [$id, $this->id];
                }
            }
            else{
                $rows[] = [$id, $this->id];
            }



        }

        Yii::$app->db->createCommand()->batchInsert(
            $table,
            $columns,
            $rows
        )->execute();


//        Utils::printAsError(Category::find()->andWhere(['id' => $ids])->one()->products);
        foreach ($ids as $id) {
//            $ad_cat=Category::findOne(Product::findOne($id)->category_id)->advertisement;
//            Utils::printAsError($ad_cat);
            $s_product = Product::findOne($id);
            if ($s_product !== null) {

                $s_product->is_discount = true;
                $s_product->discount_price = $s_product->price - ($s_product->price) * $ad_value / 100;
                $s_product->save();
            }
        }


    }

    public static function getAllProductsUnderCategory($category_id)
    {

        $category = Category::findOne($category_id);
        if (!$category) {
            return [];
        }

        $childCategoryIds = (new Advertisement)->getChildCategoryIds($category_id);
        $productIds = Product::find()
            ->select('id')
            ->where(['category_id' => array_merge([$category_id], $childCategoryIds)])
            ->column();


        return $productIds;
    }

    public function getChildCategoryIds($category_id)
    {
        $childCategories = Category::find()->where(['parent_id' => $category_id])->all();
        $childCategoryIds = [];

        foreach ($childCategories as $childCategory) {
            $childCategoryIds[] = $childCategory->id;

            $childCategoryIds = array_merge($childCategoryIds, $this->getChildCategoryIds($childCategory->id));
        }
        return $childCategoryIds;
    }


}
