<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoInscricaoMonitoria */

$this->title = $model->id . 'º Período de Inscrição';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['/monitoria/index']];
$this->params['breadcrumbs'][] = ['label' => 'Períodos de Inscrição', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodo-inscricao-monitoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você realmente deseja deletar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'dataInicio',
            'dataFim',
            'ano',
            'periodo',
        ],
    ]) ?>

    <a href="?r=periodo-inscricao-monitoria/index" class="btn btn-default">Voltar</a>

</div>
