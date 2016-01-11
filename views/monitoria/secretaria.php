<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\AlunoMonitoria;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscrições/Monitorias';
$this->params['breadcrumbs'][] = ['label' => 'Monitorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Plano Semestral', ['planosemestral'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Quadro Geral', ['gerarquadrogeral'], ['class' => 'btn btn-success']) ?>   
        <?= Html::a('Frequência Geral', ['frequenciageral'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'layout'=>"{sorter}\n{pager}\n{summary}\n{items}",
        'summary' => '',
        //'showFooter'=>true,
        'showHeader' => true,
        'columns' => [
            'nomeDisciplina',
            'professor',
            [
                'attribute'=>'periodo',
                'filter' => ArrayHelper::map(AlunoMonitoria::find()->distinct()->orderBy(['periodo' => SORT_DESC])->asArray()->all(), 'periodo', 'periodo'),
            ],
            'codTurma',
            'nomeCurso',
            [
                'attribute'=>'bolsa_traducao',
                'filter'=>array("Sim"=>"Sim","Não"=>"Não"),
            ],
            [
                'attribute'=>'status',
                'filter'=>array("Aguardando Avaliação"=>"Aguardando Avaliação", "Deferido"=>"Deferido", "Indeferido"=>"Indeferido"),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Ações',
                'headerOptions' => ['style' => 'text-align:center; color:#337AB7'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
                'template' => '{view} {delete}',
                'buttons' => 
                [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['monitoria/view', 'id' => $model->id], 
                            [
                                'title' => 'View',
                                'aria-label' => 'View',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['monitoria/delete', 'id' => $model->id], 
                            [
                                'title' => 'Delete',
                                'aria-label' => 'Delete',
                                'data-pjax' => '0',
                                'data-confirm' => 'Você realmente deseja deletar este item?',
                                'data-method' => 'post',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <a href="?r=monitoria/index" class="btn btn-default">Voltar</a>

</div>