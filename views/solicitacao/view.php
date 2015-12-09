<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitacao */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você deseja deletar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descricao',
            [
                'attribute' => 'dtInicio',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'dtTermino',
                'format' => ['date', 'php:d-m-Y']
            ],
            'horasComputadas',
            'horasMaxAtiv',
            'observacoes',
            'status',
            'atividade_id',
            'periodo_id',
            'solicitante_id',
            'aprovador_id',
            'anexo_id',
        ],
    ]) ?>

</div>
