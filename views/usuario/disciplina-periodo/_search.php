<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disciplina-periodo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idDisciplina') ?>

    <?= $form->field($model, 'codTurma') ?>

    <?= $form->field($model, 'idCurso') ?>

    <?= $form->field($model, 'idProfessor') ?>

    <?php // echo $form->field($model, 'nomeUnidade') ?>

    <?php // echo $form->field($model, 'qtdVagas') ?>

    <?php // echo $form->field($model, 'numPeriodo') ?>

    <?php // echo $form->field($model, 'anoPeriodo') ?>

    <?php // echo $form->field($model, 'dataInicioPeriodo') ?>

    <?php // echo $form->field($model, 'dataFimPeriodo') ?>

    <?php // echo $form->field($model, 'usaLaboratorio') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
