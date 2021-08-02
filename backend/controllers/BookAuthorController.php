<?php

namespace backend\controllers;

use common\models\Author;
use common\models\Book;
use common\models\BookAuthor;
use Yii;

class BookAuthorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {

    }

}
