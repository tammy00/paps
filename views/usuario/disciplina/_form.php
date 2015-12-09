<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disciplina-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codDisciplina')->textInput(['maxlength' => true, 'style'=>'width:130px']) ?>

    <?= $form->field($model, 'nomeDisciplina')->textInput(['maxlength' => true, 'style'=>'width:600px']) ?>

    <?= $form->field($model, 'cargaHoraria')->textInput(['style'=>'width:130px']) ?>

    <?= $form->field($model, 'creditos')->textInput(['style'=>'width:130px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
