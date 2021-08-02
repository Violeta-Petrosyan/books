<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\AuthorsBooksWidget;
$model = new \common\models\Author();
$form = ActiveForm::begin();?>

<?= $form->field($model, 'id')->textInput(['type'=>'number']) ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
</div>
<?= AuthorsBooksWidget::widget() ?>
<?php ActiveForm::end(); ?>
