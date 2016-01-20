<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Comissao;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComissaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comissão Avaliadora';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comissao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Avaliador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'idProfessor', 
                'value'=>'usuario.name'
            ],
            [   
                'class' => 'yii\grid\ActionColumn', 
                'header'=>'Ações', 
                'headerOptions' => ['style' => 'text-align:center; color:#337AB7'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
                'template' => '{delete}',
                'buttons' => 
                [
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['comissao/delete', 'id' => $model->id], 
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