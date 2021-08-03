<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    public $authorIds = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 25],
            [['authorIds'], 'each', 'rule'=> ['exist', 'targetClass'=>Author::class, 'targetAttribute'=> 'id' ]]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasOne(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id'=>'author_id'])->via('bookAuthors');
    }

    public function getdropAuthor()
    {
        $data = Author::find()->asArray()->all();
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function getAuthorIds()
    {
        $this->authorIds = \yii\helpers\ArrayHelper::getColumn(
            $this->getBookAuthors()->asArray()->all(),
            'author_id'
        );
        return $this->authorIds;
    }

}
