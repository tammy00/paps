<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de Solicitações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nova Solicitação', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'descricao',
            'dtInicio',
            'dtTermino',
            'horasComputadas',
            // 'horasMaxAtiv',
            // 'observacoes',
            // 'status',
            // 'atividade_id',
            // 'periodo_id',
            // 'solicitante_id',
            // 'aprovador_id',
            // 'anexo_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
