<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

$this->title = 'Relatório Semestral de Monitoria';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="monitoria-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <a href="https://www.dropbox.com/sh/1sx0q8g0c3rnmzj/AAB0GhB4RUdhuRqSdCYWdjdCa/7.%20Relat%C3%B3rio%20Final.doc?dl=0" target="_blank" class="btn btn-primary">Baixar Modelo do Relatório</a>
    <?= Html::a('Recuperar Arquivo', Url::base().'/'.$modelInfo->pathArqRelatorioSemestral, ['target'=>'_blank', 'class'=>'btn btn-primary']) ?>
    </p>
</div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Monitor',
            'value' => $modelInfo->aluno
        ],
        [
            'label' => 'Disciplina',
            'value' => $modelInfo->nomeDisciplina
        ],
        [
            'label' => 'Período',
            'value' => $modelInfo->periodo
        ],
    ],
    'options' => [
        'class' => 'table table-striped table-bordered detail-view',
        'style' => 'width:600px'
    ],
]) ?>

<div class="monitoria-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?php if ($model->errors) { ?>
            <?= $form->errorSummary($model); ?>
        <?php } ?>
        
        <?= $form->field($model, 'fileRelatorioSemestral')->fileInput() ?>

        <div class="form-group">
            <a href="?r=monitoria/professor" class="btn btn-default">Voltar</a>
            <?= Html::submitButton('Salvar Arquivo', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>