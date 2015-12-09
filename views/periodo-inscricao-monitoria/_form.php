<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoInscricaoMonitoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-inscricao-monitoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dataInicio')->widget(\yii\jui\DatePicker::classname(), [
    	'language' => 'pt-BR',
    	'dateFormat' => 'dd-MM-y',
	]) ?>

    <?= $form->field($model, 'dataFim')->widget(\yii\jui\DatePicker::classname(), [
    	'language' => 'pt-BR',
    	'dateFormat' => 'dd-MM-y',
	]) ?>

   <?= $form->field($model, 'ano')->textInput(['style'=>'width:100px']) ?>


    <?= $form->field($model, 'periodo')->dropDownList(['1' => '1', '2' => '2'], ['style'=>'width:60px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
