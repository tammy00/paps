<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Grupo;
use app\models\Curso;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Atividade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atividade-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-4">

        <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'max_horas')->textInput() ?>

        <?php
          echo $form->field($model, 'curso_id')->dropDownList(ArrayHelper::map(Curso::find()->all(), 'id', 'nome'), ['prompt'=>'Selecione']);
        ?>

        <?php
          echo $form->field($model, 'grupo_id')->dropDownList(ArrayHelper::map(Grupo::find()->all(), 'id', 'nome'), ['prompt'=>'Selecione']);
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
