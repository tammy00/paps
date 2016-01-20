<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\PeriodoInscricaoMonitoria;

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
        'summary' => '',
        //'showOnEmpty' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'ano',
                'filter' => ArrayHelper::map(PeriodoInscricaoMonitoria::find()->distinct()->orderBy(['ano' => SORT_DESC])->asArray()->all(), 'ano', 'ano'),
            ],
            [
                'attribute'=>'periodo',
                'filter' => ArrayHelper::map(PeriodoInscricaoMonitoria::find()->distinct()->orderBy(['periodo' => SORT_DESC])->asArray()->all(), 'periodo', 'periodo'),
            ],
            [
                'attribute' => 'dataInicio',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'dataFim',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Ações',
                'headerOptions' => ['style' => 'text-align:center; color:#337AB7'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
            ],
        ],
    ]); ?>

    <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>

</div>
