<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitacaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'dtInicio') ?>

    <?= $form->field($model, 'dtTermino') ?>

    <?= $form->field($model, 'horasComputadas') ?>

    <?php // echo $form->field($model, 'horasMaxAtiv') ?>

    <?php // echo $form->field($model, 'observacoes') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'atividade_id') ?>

    <?php // echo $form->field($model, 'periodo_id') ?>

    <?php // echo $form->field($model, 'solicitante_id') ?>

    <?php // echo $form->field($model, 'aprovador_id') ?>

    <?php // echo $form->field($model, 'anexo_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
