<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int $user_id
 * @property string $image
 * @property string $title
 * @property string $body
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Review[] $reviews
 * @property User $user
 */
class Blog extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'body'], 'required'],
            [['user_id'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true],
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
            'image' => Yii::t('app', 'Image'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['blog_id' => 'id']);
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


    public function getImageUrl(){

        if ($this->image){
            return 'http://localhost:8888/'. $this->image;
        }

        return Yii::getAlias('@backend') . '/web/default-image.jpg';
    }

    public function getShortDescription($length = 200){

        $description = strip_tags($this->body);

        if (strlen($description) > $length){
            $description = substr($description, 0, $length) . '...';
        }

        return $description;
    }


}
