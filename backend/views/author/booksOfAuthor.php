<?php

use backend\widgets\AuthorsBooksWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$model = new \common\models\Author();
$form = ActiveForm::begin();?>

<?= $form->field($model, 'id')->textInput(['type'=>'number']) ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
</div>

<?php
    $id = '';
    if(Yii::$app->request->post()) {
        $id = (intval((Yii::$app->request->post()["Author"]["id"])));
    }
    if(!$id) {
        echo "Please enter the Id.";
    }
?>
<?= AuthorsBooksWidget::widget(['author'=> $id]) ?>
<?php ActiveForm::end(); ?>

