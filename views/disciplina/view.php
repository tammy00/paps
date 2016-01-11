<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */

$this->title = $model->nomeDisciplina;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas UFAM', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você realmente deseja deletar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'codDisciplina',
            'nomeDisciplina',
            'cargaHoraria',
            'creditos',
            //'possuiMonitoria',
            [
                'label' => 'Disciplina com Monitoria',
                'value' => $model->traducao_possui_monitoria
            ],
        ],
    ]) ?>

    <a href="?r=disciplina/index" class="btn btn-default">Voltar</a>

</div>
