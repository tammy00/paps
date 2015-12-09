<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaPeriodo */

$this->title = $model->disciplina->nomeDisciplina . ' - ' . $model->codTurma;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas do Período', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-periodo-view">

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
            //'idDisciplina',
            'disciplina.nomeDisciplina',
            //[
            //    'attribute'=>'idDisciplina',
            //    'value'=>$model->disciplina->nomeDisciplina,
            //    'type'=>DetailView::INPUT_SELECT2, 
            //    'widgetOptions'=>[
            //        'data'=>ArrayHelper::map(Disciplina::find()->orderBy('nomeDisciplina')->asArray()->all(), 'id', 'nomeDisciplina'),
            //    ]
            //],
            'codTurma',
            //'idCurso',
            'curso.nome',
            //'idProfessor',
            'professor.Nome',
            'nomeUnidade',
            'qtdVagas',
            'numPeriodo',
            'anoPeriodo',
            'dataInicioPeriodo',
            'dataFimPeriodo',
            'usaLaboratorio',
        ],
    ]) ?>

</div>
