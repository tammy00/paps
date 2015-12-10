<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            'anoPeriodo',
            'numPeriodo',
            // 'dataInicioPeriodo',
            // 'dataFimPeriodo',
            // 'usaLaboratorio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
