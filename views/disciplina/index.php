<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisciplinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disciplinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Disciplina', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'codDisciplina',
            'nomeDisciplina',
            //'cargaHoraria',
            //'creditos',
            [
                'attribute'=> 'traducao_possui_monitoria',
                'label'=>'Disciplina com Monitoria',
                'filter'=>array("1"=>"Sim","0"=>"Não"),
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
