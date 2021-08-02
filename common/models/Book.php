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

    public function afterSave($insert, $changedAttributes=null)
    {
        $actualAuthors = [];
        $authorExists = 0; //for updates

        if (($actualAuthors = BookAuthor::find()
                ->andWhere("book_id = $this->id")
                ->asArray()
                ->all()) !== null) {
            $actualAuthors = ArrayHelper::getColumn($actualAuthors, 'author_id');
            $authorExists = 1; // if there is authors relations, we will work it latter
        }

        if (!empty($this->despIds)) { //save the relations
            foreach ($this->despIds as $id) {
                $actualAuthors = array_diff($actualAuthors, [$id]); //remove remaining authors from array
                $r = new BookAuthor();
                $r->book_id = $this->id;
                $r->author_id = $id;
                $r->save();
            }
        }

        if ($authorExists == 1) { //delete authors tha does not belong anymore to this book
            foreach ($actualAuthors as $remove) {
                $r = BookAuthor::findOne(['author_id' => $remove, 'book_id' => $this->id]);
                $r->delete();
            }
        }

        /*$bookAuther = new BookAuthor();
        foreach ($this->authorIds as $authorId) {*/



        parent::afterSave($insert, $changedAttributes=null); //don't forget this
    }
}
