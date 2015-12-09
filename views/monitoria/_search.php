<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MonitoriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monitoria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'numProcs') ?>

    <?= //$form->field($model, 'IDAluno') ?>

    <?= $form->field($model, 'IDDisc') ?>

    <?= $form->field($model, 'IDCurso') ?>

    <?php // echo $form->field($model, 'bolsa') ?>

    <div class="form-group">
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Resetar', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
