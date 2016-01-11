<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\DisciplinaPeriodo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisciplinaPeriodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disciplinas do Período';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Disciplina do Período', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Importar Disciplinas - Arquivo CSV', ['importarcsv'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'idDisciplina',
            [
                'attribute'=>'idDisciplina', 
                'value'=>'disciplina.nomeDisciplina'
            ],
            'codTurma',
            //'idCurso',
            [
                'attribute'=>'idCurso', 
                'value'=>'curso.nome'
            ],
            //'idProfessor',
            [
                'attribute'=>'idProfessor', 
                'value'=>'usuario.name'
            ],
            // 'nomeUnidade',
            // 'qtdVagas',
            //'anoPeriodo',
            //'numPeriodo',
            [
                'attribute'=>'anoPeriodo',
                'filter' => ArrayHelper::map(DisciplinaPeriodo::find()->distinct()->orderBy(['anoPeriodo' => SORT_DESC])->asArray()->all(), 'anoPeriodo', 'anoPeriodo'),
            ],
            [
                'attribute'=>'numPeriodo',
                'filter' => ArrayHelper::map(DisciplinaPeriodo::find()->distinct()->orderBy(['numPeriodo' => SORT_DESC])->asArray()->all(), 'numPeriodo', 'numPeriodo'),
            ],
            // 'dataInicioPeriodo',
            // 'dataFimPeriodo',
            // 'usaLaboratorio',
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
