<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ProfessorMonitoria;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfessorMonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Monitorias';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'layout'=>"{sorter}\n{pager}\n{summary}\n{items}",
        'summary' => '',
        //'showFooter'=>true,
        'showHeader' => true,
        'columns' => [
            [
                'attribute'=>'codDisciplina',
                'label'=>'Cod. Disciplina'
            ],
            'nomeDisciplina',
            'aluno',
            'codTurma',
            'nomeCursoDisciplina',
            //'nomeCursoAluno',
            [
                'attribute'=>'periodo',
                'filter' => ArrayHelper::map(ProfessorMonitoria::find()->distinct()->orderBy(['periodo' => SORT_DESC])->asArray()->all(), 'periodo', 'periodo'),
            ],
            [
                'attribute'=> 'bolsa_traducao',
                'filter'=>array("Sim"=>"Sim","Não"=>"Não"),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Ações',
                'headerOptions' => ['style' => 'text-align:center; color:#337AB7'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
                'template' => '{plano} {relatorio}',
                'buttons' => 
                [
                    'plano' => function ($url, $model) {
                        return Html::a(
                            '<span class="btn btn-primary">Plano Disciplina</span>',
                            ['monitoria/gerarplanosemestraldisciplina', 'id' => $model->id], 
                            [
                                'title' => 'Plano Disciplina',
                                'aria-label' => 'Plano Disciplina',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'relatorio' => function ($url, $model) {
                        return Html::a(
                            '<span class="btn btn-primary">Relatório</span>',
                            ['monitoria/gerarrelatoriosemestral', 'id' => $model->id], 
                            [
                                'title' => 'Relatório Semestral',
                                'aria-label' => 'Relatório Semestral',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>

</div>
