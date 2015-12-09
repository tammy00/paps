<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
$this->title = 'Lista de Cursos';
?>
<div class="curso-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo Curso', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => [
            'codigo',
            'nome',
            'max_horas',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
