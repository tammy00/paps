<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodoInscricaoMonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Períodos de Inscrição para Monitoria';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['/monitoria/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodo-inscricao-monitoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Período de Inscrição', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'dataInicio',
            'dataFim',
            'ano',
            'periodo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>

</div>
