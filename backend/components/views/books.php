<?  /*@var $author common\models\Author*/ ?>

<div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title'
        ]
    ]); ?>
</div>


