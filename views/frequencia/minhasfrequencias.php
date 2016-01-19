<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonitoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Frequências registradas';
$this->params['breadcrumbs'][] = ['label' => 'Frequências', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty'=> false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'dmy',
                'format' => ['date', 'php:d-m-Y']
            ],
            'ch',
            'atividade',
            [

                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

    <p> 
        <a href="?r=monitoria/aluno" class="btn btn-default">Gerenciar Monitorias</a>
        <a href="?r=monitoria/index" class="btn btn-default">Menu de Monitoria</a>
    </p>

</div>
