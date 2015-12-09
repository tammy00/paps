<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="col-md-4">
   
    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dtInicio')->widget(\yii\jui\DatePicker::classname(), [
            'language' => 'pt-BR',
            'dateFormat' => 'dd-M-y',
    ]) ?>
    <?= $form->field($model, 'dtTermino')->widget(\yii\jui\DatePicker::classname(), [
            'language' => 'pt-BR',
            'dateFormat' => 'dd-M-y',
    ]) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
